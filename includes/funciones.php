<?php
    define('TEMPLATES_URL',__DIR__. '/templates');
    define('FUNCIONES_URL',__DIR__. 'funciones.php');
    define('CARPETA_IMAGENES',$_SERVER['DOCUMENT_ROOT'].'/imagenes/');
    function incluirTemplate(string $nombre,bool $inicio=false){
        $inicio;
        include TEMPLATES_URL ."/".$nombre.".php";
    }

    function estaAutenticado(){
        session_start();
        if(!$_SESSION['login']){
            header('Location:/');
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
    //Escapa el html (agrega seguridad de inyecciones en los inputs de los formularios)
    function s($html):string{
        $s=htmlspecialchars($html);
        return $s;
    }

    function comprobarId($tipo){
        $tipos=['propiedades','vendedores'];
        return in_array($tipo,$tipos);
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