<?php 

    
    namespace Controllers;

    use MVC\Router;
    use Model\Propiedad;
    
    class PaginasController {

        public static function index(Router $router){
            $propiedades=Propiedad::get(3);
            $router->render("paginas/index",["inicio"=>true,"propiedades"=>$propiedades]);

        }
        public static function nosotros(Router $router){
            $router->render("paginas/nosotros",[]);
        }

        public static function anuncios(Router $router){
            $propiedades=Propiedad::all();
            $router->render("paginas/anuncios",["propiedades"=>$propiedades]);
        }
        public static function anuncio(Router $router){
            $id=filter_var($_GET['id'] ?? null,FILTER_VALIDATE_INT);
            //obtener datos de la propiedad
            $propiedad=$id ? Propiedad::find($id) : false;
            //si no existe se regresa al listado y se DETIENE la ejecucion
            if(!$propiedad){
                header('Location:'.url('/anuncios'));
                exit;
            }
            $router->render("paginas/anuncio",["propiedad"=>$propiedad]);
        }

        public static function blog(Router $router){
            $router->render("paginas/blog",[]);
        }
        public static function entrada(Router $router){
            $router->render("paginas/entrada",[]);
        }

        //lee un campo de texto del formulario de contacto (siempre devuelve un string limpio)
        private static function campo($datos,$nombre,$maximo=500){
            $valor=$datos[$nombre] ?? '';
            return is_string($valor) ? mb_substr(trim($valor),0,$maximo) : '';
        }

        public static function contacto(Router $router){
            $mensaje=null;
            $claseMensaje='exito';
            if($_SERVER['REQUEST_METHOD']==='POST'){
                $datos=is_array($_POST['contacto'] ?? null) ? $_POST['contacto'] : [];
                $nombre=self::campo($datos,'nombre',100);
                $texto=self::campo($datos,'mensaje',2000);
                $tipo=self::campo($datos,'tipo',20);
                $presupuesto=self::campo($datos,'presupuesto',20);
                $contacto=self::campo($datos,'contacto',20);
                $telefono=self::campo($datos,'telefono',20);
                $fecha=self::campo($datos,'fecha',20);
                $hora=self::campo($datos,'hora',20);
                $email=self::campo($datos,'email',100);

                if(self::campo($_POST,'sitio_web')!==''){
                    //campo trampa oculto: solo lo llenan los robots. Se finge exito sin enviar nada
                    $mensaje='El mensaje se envio correctamente';
                }elseif(isset($_SESSION['ultimo_contacto']) && time()-(int)$_SESSION['ultimo_contacto']<30){
                    //limite sencillo contra el envio masivo: un mensaje cada 30 segundos por visitante
                    $mensaje='Espera unos segundos antes de enviar otro mensaje';
                    $claseMensaje='error';
                }elseif($nombre==='' || $texto==='' || !in_array($tipo,['comprar','vender'],true)){
                    $mensaje='Completa tu nombre, tu mensaje y si quieres comprar o vender';
                    $claseMensaje='error';
                }elseif($contacto==='email' && !filter_var($email,FILTER_VALIDATE_EMAIL)){
                    $mensaje='El email no es valido';
                    $claseMensaje='error';
                }elseif($presupuesto!=='' && !is_numeric($presupuesto)){
                    $mensaje='El presupuesto debe ser un numero';
                    $claseMensaje='error';
                }else{
                    //contenido del correo (todo lo que escribe el visitante se escapa antes de ponerlo en el html)
                    $contenido='<html>';
                    $contenido.='<p>un nuevo mensaje desde bienes raices</p>';
                    $contenido.='<p>Nombre: '.s($nombre).'</p>';
                    $contenido.='<p>Mensaje: '.s($texto).'</p>';
                    $contenido.='<p>Quiere: '.s($tipo).'</p>';
                    $contenido.='<p>Presupuesto: $'.s($presupuesto).'</p>';
                    $plano="un nuevo mensaje desde bienes raices\nNombre: $nombre\nMensaje: $texto\nQuiere: $tipo\nPresupuesto: $presupuesto\n";

                    if($contacto==='telefono'){
                        $contenido.='<p>Elijio ser contactado por telefono</p>';
                        $contenido.='<p>Telefono: '.s($telefono).'</p>';
                        $contenido.='<p>Fecha para contactar: '.s($fecha).'</p>';
                        $contenido.='<p>Hora para contactar: '.s($hora).'</p>';
                        $plano.="Contactar por telefono: $telefono, fecha $fecha, hora $hora\n";
                    }elseif($contacto==='email'){
                        $contenido.='<p>Elijio ser contactado por Email</p>';
                        $contenido.='<p>Email: '.s($email).'</p>';
                        $plano.="Contactar por email: $email\n";
                    }
                    $contenido.='</html>';

                    $destino=env('CONTACTO_EMAIL',env('MAIL_FROM','contacto@bienesraices.com'));
                    //enviar email
                    if(enviarCorreo($destino,'Un nuevo mensaje desde BienesRaices.com',$contenido,$plano,$contacto==='email' ? $email : '')){
                        $mensaje='El mensaje se envio correctamente';
                        $_SESSION['ultimo_contacto']=time();
                    }else{
                        $mensaje='error al enviar el mensaje';
                        $claseMensaje='error';
                    }
                }

            }
            $router->render("paginas/contacto",["mensaje"=>$mensaje,"claseMensaje"=>$claseMensaje]);
        }

    }
