<?php
    define('TEMPLATES_URL',__DIR__. '/templates');
    define('FUNCIONES_URL',__DIR__. '/funciones.php');
    //carpeta donde se guardan las fotos de las propiedades: public/imagenes
    //(no depende de DOCUMENT_ROOT, asi funciona igual si el sitio apunta a la raiz o a public/)
    define('CARPETA_IMAGENES',__DIR__.'/../public/imagenes/');

    //lee una variable de configuracion. Busca en $_ENV, $_SERVER y getenv(), porque segun la
    //configuracion de PHP (variables_order) las variables reales del servidor no siempre estan en $_ENV
    function env(string $clave,$default=null){
        if(isset($_ENV[$clave]) && $_ENV[$clave]!==''){ return $_ENV[$clave]; }
        if(isset($_SERVER[$clave]) && is_string($_SERVER[$clave]) && $_SERVER[$clave]!==''){ return $_SERVER[$clave]; }
        $valor=getenv($clave);
        return ($valor!==false && $valor!=='') ? $valor : $default;
    }

    //ruta base donde vive la aplicacion: vacia si esta en la raiz del dominio (https://sitio.com) o por ejemplo
    ///bienes-raices si comparte dominio con otra app (https://sitio.com/bienes-raices). Se define con APP_BASE_PATH en el .env
    $baseConfigurada=trim((string)env('APP_BASE_PATH',''),'/');
    define('BASE_PATH',$baseConfigurada==='' ? '' : '/'.$baseConfigurada);
    //arma una direccion interna de la app respetando la ruta base: url('/admin') => /bienes-raices/admin
    function url(string $ruta='/'):string{
        return BASE_PATH.$ruta;
    }

    function incluirTemplate(string $nombre,bool $inicio=false){
        include TEMPLATES_URL ."/".$nombre.".php";
    }

    //si no hay sesion iniciada redirige al login y DETIENE la ejecucion
    function estaAutenticado(){
        if(session_status()===PHP_SESSION_NONE){
            session_start();
        }
        if(empty($_SESSION['login'])){
            header('Location:'.url('/login'));
            exit;
        }
    }

    function debugear($variable){
        echo '<pre>';
        var_dump($variable);
        echo '</pre>';
        exit;
    }
    function debugear2($variable){
        echo $variable;
        
        exit;
    }
    //Escapa el html (agrega seguridad contra XSS al mostrar datos en las vistas)
    function s($html):string{
        return htmlspecialchars((string)$html,ENT_QUOTES,'UTF-8');
    }

    function comprobarId($tipo){
        $tipos=['propiedades','vendedores'];
        return in_array($tipo,$tipos,true);
    }
    function mostrarMensajeAdmin($resultado){
        $mensaje='';
        switch($resultado){
            case 1:
                $mensaje="Se Inserto Correctamente";
                break;
            case 2:
                $mensaje="Se Actualizo Correctamente";
                break;
            case 3:
                $mensaje="Se Elimino Correctamente";
                break;
            default:
                $mensaje=false;
                break;

        }
        return $mensaje;
    }

    //envia un correo por SMTP con PHPMailer. Devuelve true si salio bien, false si fallo (el detalle va al log)
    //si MAIL_HOST no esta configurado (desarrollo local) no se envia nada: el contenido queda en el log de PHP
    function enviarCorreo(string $destinatario,string $asunto,string $html,string $textoPlano,string $responderA=''):bool{
        $host=env('MAIL_HOST');
        if(!$host){
            error_log("[BienesRaices] MAIL_HOST no configurado. Correo para {$destinatario} - {$asunto} - ".$textoPlano);
            return true;
        }
        try{
            $mail=new PHPMailer\PHPMailer\PHPMailer(true);
            $mail->isSMTP();
            $mail->Host=$host;
            $mail->SMTPAuth=true;
            $mail->Username=env('MAIL_USER','');
            $mail->Password=env('MAIL_PASS','');
            $cifrado=strtolower((string)env('MAIL_ENCRYPTION','tls'));
            if($cifrado==='ssl'){
                $mail->SMTPSecure=PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;
            }elseif($cifrado==='tls'){
                $mail->SMTPSecure=PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
            }else{
                $mail->SMTPSecure='';
                $mail->SMTPAutoTLS=false;
            }
            $mail->Port=(int) env('MAIL_PORT',587);
            $mail->Timeout=10;
            $mail->setFrom(env('MAIL_FROM','contacto@bienesraices.com'),'BienesRaices.com');
            $mail->addAddress($destinatario,'BienesRaices.com');
            //responder directamente al cliente que escribio (solo si dejo un email valido)
            if($responderA!=='' && filter_var($responderA,FILTER_VALIDATE_EMAIL)){
                $mail->addReplyTo($responderA);
            }
            $mail->Subject=$asunto;
            $mail->isHTML(true);
            $mail->CharSet='UTF-8';
            $mail->Body=$html;
            $mail->AltBody=$textoPlano;
            $mail->send();
            return true;
        }catch(\Throwable $e){
            error_log('[BienesRaices] No se pudo enviar el correo: '.$e->getMessage());
            return false;
        }
    }
