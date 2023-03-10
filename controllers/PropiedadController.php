<?php 
    namespace Controllers;
    use MVC\Router;
    use Model\Propiedad;
    use Model\Vendedor;
    use Intervention\Image\ImageManagerStatic as Image;

    class PropiedadController{

        public static function index(Router $router){
            $propiedades=Propiedad::all();
            $vendedores=Vendedor::all();
            $resultado=$_GET['resultado'] ?? null;
            //validacion del metodo post para eliminar una propiedad 
            if($_SERVER['REQUEST_METHOD']==='POST'){
        
                $tipo=$_POST['tipo'];
                // debugear($tipo);
                $id=$_POST['id'];
                $id=filter_var($id,FILTER_VALIDATE_INT);
                if($id){
                    //se verifica si existe el tipo del modelo(propiedad o vendedor para ser eliminado)
                    if(comprobarId($tipo)){
                        if($tipo==='propiedades'){
                            $propiedad=Propiedad::find($id);
                            $propiedad->eliminar();
                        }elseif($tipo==='vendedores'){
                            $vendedor=Vendedor::find($id);
                            $vendedor->eliminar();
                        }
                    }  
                }
            }
            $router->render("propiedades/admin",
                            ["propiedades"=>$propiedades,
                            "resultado"=>$resultado,
                            "vendedores"=>$vendedores
                        ]);
        }
        public static function crear(Router $router){
            $propiedad=new Propiedad;
            $vendedores=Vendedor::all();
            
            if($_SERVER['REQUEST_METHOD']==='POST'){
                $propiedad=new Propiedad($_POST);

                //generar nombre de la imagen unico
                $nombreImagen=md5(uniqid(rand(),true)).'.jpg';
                if($_FILES['imagen']['tmp_name']){
                    //almacena el arreglo de la variable gobal FILES contenida dentro  de otro arreglo 
                    $imagen=$_FILES['imagen'];
                    //realiza un resize a la imagen con intervention
                    $image=Image::make($imagen['tmp_name'])->fit(800,600);
                    //asigan el nombre ya hasheado a la instancia de propiedad para ser validada
                    $propiedad->setImagen($nombreImagen);
                }
                $propiedad->validar();

                $errores=Propiedad::getErrores();

                if(empty($errores)){
                    //creacion de la carpeta imagenes
            
                    if(! is_dir(CARPETA_IMAGENES) ){
                        mkdir(CARPETA_IMAGENES);
                    }
                
                    //guarda la imagen en el servidor 
                    $image->save(CARPETA_IMAGENES.$nombreImagen);

                    $resultado=$propiedad->guardar();
                    if($resultado){ 
                        echo 'se insertaron correctamente los datos';
                        header('Location:/admin?resultado=1');
                    }else{
                        echo 'no se pudieron insertar los datos';
                    }

                }

            }
            $router->render("propiedades/crear",
                            ["propiedad"=>$propiedad,
                            "vendedores"=>$vendedores,
                            "errores"=>$errores]);

        }
        public static function actualizar(Router $router){
            $propiedadId=$_GET['id'];
            $propiedadId=filter_var($propiedadId,FILTER_VALIDATE_INT);
            if(!$propiedadId || !Propiedad::find($propiedadId)){
                header('Location:/admin');
            }
            $propiedad=Propiedad::find($propiedadId);
            $vendedores=Vendedor::all();
            $errores=Propiedad::getErrores();
            if($_SERVER['REQUEST_METHOD']==='POST'){
        
                $args=($_POST['propiedad']); 
                //debugear($args);
                $propiedad=$propiedad->sincronizar($args);
            
                $nombreImagen=md5(uniqid(rand(),true)).'.jpg';
                //debugear($_FILES['propiedad']['tmp_name']['imagen']);

                if($_FILES['propiedad']['tmp_name']['imagen']){
                //realiza un resize a la imagen con intervention
                    $image=Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800,600);
                    //asigan el nombre ya hasheado a la instancia de propiedad para ser validada
                    $propiedad->setImagen($nombreImagen);
                }
                $propiedad->validar();
                $errores=Propiedad::getErrores();
                if(empty($errores)){
                    //creacion de la carpeta imagenes
                    //$carpetaImagenes='../../imagenes/';
        
                    if(! is_dir(CARPETA_IMAGENES) ){
                        mkdir(CARPETA_IMAGENES);
                    }
                    if($image){
                    $image->save(CARPETA_IMAGENES.$nombreImagen);
                    }
                    $resultado=$propiedad->actualizar();
            
                    if($resultado){ 
                        echo 'se insertaron correctamente los datos';
                        header('Location:/admin?resultado=2');
                    }else{
                        echo 'no se pudieron insertar los datos';
                    }
                }
            }

            $router->render('propiedades/actualizar',
                            ["propiedad"=>$propiedad,
                            "vendedores"=>$vendedores,
                            "errores"=>$errores]);
        }
        public static function borrar(){
            debugear('borrar');
        }

    }
