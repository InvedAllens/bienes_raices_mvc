<?php 

    
    namespace Controllers;

    use MVC\Router;
    use Model\Propiedad;
    use PHPMailer\PHPMailer\PHPMailer;
    
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
            $id=$_GET['id'];
            $id=filter_var($id,FILTER_VALIDATE_INT);
            if(!$id || !Propiedad::find($id)!=null){
                header('Location:/anuncios');
            }
            //obtener datos de la propiedad
            $propiedad=Propiedad::find($id);
            $router->render("paginas/anuncio",["propiedad"=>$propiedad]);
        }

        public static function blog(Router $router){
            $router->render("paginas/blog",[]);
        }
        public static function entrada(Router $router){
            $router->render("paginas/entrada",[]);
        }

        public static function contacto(Router $router){
            $mensaje=null;
            if($_SERVER['REQUEST_METHOD']==='POST'){
                //debugear($_POST['contacto']);
                $resultado=$_POST['contacto'];
                //creacion de una instancia de phpmailer
                $mail=new PHPMailer();
                //configuracion de conexion con el servicio de mailer SMTP
                $mail->isSMTP();
                $mail->Host='sandbox.smtp.mailtrap.io';
                $mail->SMTPAuth=true;
                $mail->Username='546e99008c2430';
                $mail->Password='5481afa33c809f';
                $mail->SMTPSecure='tls';
                $mail->Port=2525;
                //configurar el contenido del mail
                $mail->setFrom('admin@bienesraices.com');
                $mail->addAddress('admin@bienesraices.com','BienesRaices.com');
                $mail->Subject="Un nuevo mensaje desde BienesRaices.com";
                //habilitar html
                $mail->isHTML(true);
                $mail->CharSet='utf-8';
                //definir el contenido
                $contenido='<html>';
                $contenido.='<p>un nuevo mensaje desde biene raices</p>';
                $contenido.='<p>Nombre:'.$resultado['nombre'].'</p>';
                
                
                $contenido.='<p>Mensaje:'.$resultado['mensaje'].'</p>';
                $contenido.='<p>Quiere:'.$resultado['tipo'].'</p>';
                $contenido.='<p>Presupuesto:$'.$resultado['presupuesto'].'</p>';

                if($resultado['contacto']==="telefono"){
                    $contenido.='<p>Elijio ser contactado por telefono</p>';
                    $contenido.='<p>Telefono:'.$resultado['telefono'].'</p>';
                    $contenido.='<p>Fecha para contactar:'.$resultado['fecha'].'</p>';
                    $contenido.='<p>Hora para contactar:'.$resultado['hora'].'</p>';

                }else{
                    $contenido.='<p>Elijio ser contactado por Email</p>';
                    $contenido.='<p>Email:'.$resultado['email'].'</p>';
                }
                
                //$contenido.='<p>Preferiere ser contactado por:'.$resultado['contacto'].'</p>';
               
                $contenido.='</html>';
                $mail->Body=$contenido;
                $mail->AltBody="un nuevo mensaje desde biene raices,
                Nombre: $resultado[nombre]
                Email:$resultado[email]
                Mensaje:$resultado[mensaje]
                Presupuesto:$resultado[presupuesto]
                ";
                //enviar email
                if($mail->send()){
                    $mensaje="El mensaje se envio correctamente";
                }else{
                    $mensaje='error al enviar el mensaje';
                }

            }
            $router->render("paginas/contacto",["mensaje"=>$mensaje]);
        }

    }
