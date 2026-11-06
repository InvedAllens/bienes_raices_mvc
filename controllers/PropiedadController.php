<?php 
    namespace Controllers;
    use MVC\Router;
    use Model\Propiedad;
    use Model\Vendedor;
    use Intervention\Image\ImageManagerStatic as Image;

    class PropiedadController{

        //unicos campos del formulario que se copian a la propiedad (nunca el id ni la imagen)
        private const CAMPOS=['titulo','precio','descripcion','habitaciones','wc','estacionamiento','vendedores_idvendedor'];

        //genera un nombre unico e impredecible para la imagen
        private static function nombreImagen(){
            return bin2hex(random_bytes(16)).'.jpg';
        }
        //borra una imagen de la carpeta de imagenes (basename evita salirse de la carpeta)
        private static function borrarImagen($nombre){
            $nombre=basename((string)$nombre);
            if($nombre!=='' && is_file(CARPETA_IMAGENES.$nombre)){
                @unlink(CARPETA_IMAGENES.$nombre);
            }
        }
        //valida y prepara la imagen subida. Devuelve [imagen redimensionada|null, mensaje de error|null]
        private static function leerImagen($archivo){
            if(!is_array($archivo) || ($archivo['error'] ?? UPLOAD_ERR_NO_FILE)===UPLOAD_ERR_NO_FILE){
                return [null,null];
            }
            if($archivo['error']!==UPLOAD_ERR_OK){
                return [null,'No se pudo subir la imagen (puede ser demasiado pesada)'];
            }
            //se comprueba el contenido real del archivo, no solo lo que dice el navegador
            $info=@getimagesize($archivo['tmp_name']);
            if(!$info || !in_array($info[2],[IMAGETYPE_JPEG,IMAGETYPE_PNG],true)){
                return [null,'La imagen debe ser JPG o PNG'];
            }
            try{
                //realiza un resize a la imagen con intervention
                return [Image::make($archivo['tmp_name'])->fit(800,600),null];
            }catch(\Throwable $e){
                error_log('[BienesRaices] No se pudo procesar la imagen: '.$e->getMessage());
                return [null,'No se pudo procesar la imagen'];
            }
        }

        public static function index(Router $router){
            $resultado=$_GET['resultado'] ?? null;
            $error=null;
            //validacion del metodo post para eliminar una propiedad o un vendedor
            if($_SERVER['REQUEST_METHOD']==='POST'){
                $tipo=is_string($_POST['tipo'] ?? null) ? $_POST['tipo'] : '';
                $id=filter_var($_POST['id'] ?? null,FILTER_VALIDATE_INT);
                //se verifica si existe el tipo del modelo(propiedad o vendedor para ser eliminado)
                if($id && comprobarId($tipo)){
                    try{
                        $registro=($tipo==='propiedades') ? Propiedad::find($id) : Vendedor::find($id);
                        if($registro && $registro->eliminar()){
                            if($tipo==='propiedades'){
                                self::borrarImagen($registro->imagen);
                            }
                            header('Location:'.url('/admin?resultado=3'));
                            exit;
                        }
                    }catch(\mysqli_sql_exception $e){
                        error_log('[BienesRaices] No se pudo eliminar: '.$e->getMessage());
                        $error=($tipo==='vendedores')
                            ? 'No se puede eliminar un vendedor que tiene propiedades asignadas. Elimina o reasigna primero sus propiedades.'
                            : 'No se pudo eliminar el registro.';
                    }
                }
            }
            $propiedades=Propiedad::all();
            $vendedores=Vendedor::all();
            $router->render("propiedades/admin",
                            ["propiedades"=>$propiedades,
                            "resultado"=>$resultado,
                            "vendedores"=>$vendedores,
                            "error"=>$error
                        ]);
        }
        public static function crear(Router $router){
            $propiedad=new Propiedad;
            $vendedores=Vendedor::all();
            $errores=[];
            
            if($_SERVER['REQUEST_METHOD']==='POST'){
                $propiedad=new Propiedad;
                $propiedad->sincronizar($_POST,self::CAMPOS);

                //generar nombre de la imagen unico
                $nombreImagen=self::nombreImagen();
                [$image,$errorImagen]=self::leerImagen($_FILES['imagen'] ?? null);
                if($image){
                    //asigan el nombre ya hasheado a la instancia de propiedad para ser validada
                    $propiedad->setImagen($nombreImagen);
                }
                $propiedad->validar();

                $errores=Propiedad::getErrores();
                if($errorImagen){
                    $errores[]=$errorImagen;
                }

                if(empty($errores)){
                    try{
                        //creacion de la carpeta imagenes
                        if(! is_dir(CARPETA_IMAGENES) ){
                            mkdir(CARPETA_IMAGENES,0755,true);
                        }
                        //guarda la imagen en el servidor 
                        $image->save(CARPETA_IMAGENES.$nombreImagen);

                        if($propiedad->guardar()){ 
                            header('Location:'.url('/admin?resultado=1'));
                            exit;
                        }
                        //si no se pudo guardar en la base de datos no se deja la imagen huerfana
                        self::borrarImagen($nombreImagen);
                        $errores[]='No se pudieron guardar los datos';
                    }catch(\Throwable $e){
                        error_log('[BienesRaices] No se pudo crear la propiedad: '.$e->getMessage());
                        self::borrarImagen($nombreImagen);
                        $errores[]='No se pudo guardar la propiedad, intenta de nuevo';
                    }
                }

            }
            $router->render("propiedades/crear",
                            ["propiedad"=>$propiedad,
                            "vendedores"=>$vendedores,
                            "errores"=>$errores]);

        }
        public static function actualizar(Router $router){
            $propiedadId=filter_var($_GET['id'] ?? null,FILTER_VALIDATE_INT);
            $propiedad=$propiedadId ? Propiedad::find($propiedadId) : false;
            //si no existe la propiedad se regresa al panel y se DETIENE la ejecucion
            if(!$propiedad){
                header('Location:'.url('/admin'));
                exit;
            }
            $vendedores=Vendedor::all();
            $errores=[];
            if($_SERVER['REQUEST_METHOD']==='POST'){
        
                $args=$_POST['propiedad'] ?? [];
                //solo se copian los campos permitidos: asi no se puede enviar otro idpropiedad para modificar otra propiedad
                $propiedad->sincronizar(is_array($args) ? $args : [],self::CAMPOS);
                $imagenAnterior=$propiedad->imagen;
            
                $nombreImagen=self::nombreImagen();
                //con el campo propiedad[imagen] PHP agrupa los datos del archivo dentro de $_FILES['propiedad']
                $archivo=isset($_FILES['propiedad']['tmp_name']['imagen']) ? [
                    'tmp_name'=>$_FILES['propiedad']['tmp_name']['imagen'],
                    'error'=>$_FILES['propiedad']['error']['imagen'] ?? UPLOAD_ERR_NO_FILE
                ] : null;
                [$image,$errorImagen]=self::leerImagen($archivo);
                if($image){
                    //asigan el nombre ya hasheado a la instancia de propiedad para ser validada
                    $propiedad->setImagen($nombreImagen);
                }
                $propiedad->validar();
                $errores=Propiedad::getErrores();
                if($errorImagen){
                    $errores[]=$errorImagen;
                }
                if(empty($errores)){
                    try{
                        if($image){
                            if(! is_dir(CARPETA_IMAGENES) ){
                                mkdir(CARPETA_IMAGENES,0755,true);
                            }
                            $image->save(CARPETA_IMAGENES.$nombreImagen);
                        }
                        if($propiedad->actualizar()){ 
                            //la imagen anterior se borra hasta que los cambios ya se guardaron
                            if($image){
                                self::borrarImagen($imagenAnterior);
                            }
                            header('Location:'.url('/admin?resultado=2'));
                            exit;
                        }
                        if($image){
                            self::borrarImagen($nombreImagen);
                        }
                        $errores[]='No se pudieron actualizar los datos';
                    }catch(\Throwable $e){
                        error_log('[BienesRaices] No se pudo actualizar la propiedad: '.$e->getMessage());
                        if($image){
                            self::borrarImagen($nombreImagen);
                        }
                        $errores[]='No se pudo actualizar la propiedad, intenta de nuevo';
                    }
                }
                //si algo fallo se sigue mostrando la imagen anterior
                if(!empty($errores) && $image){
                    $propiedad->imagen=$imagenAnterior;
                }
            }

            $router->render('propiedades/actualizar',
                            ["propiedad"=>$propiedad,
                            "vendedores"=>$vendedores,
                            "errores"=>$errores]);
        }
    }
