<?php 
    //Mientras se cargan las librerias NO se muestran avisos en pantalla. Con PHP 8.4 algunas librerias (como
    //phpdotenv) emiten avisos "deprecated"; si se imprimen antes de iniciar la sesion o de redirigir, el login
    //y las redirecciones dejan de funcionar ("headers already sent"). Los errores siguen guardandose en el log.
    ini_set('display_errors','0');
    error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);

    require __DIR__.'/../vendor/autoload.php';
    //busca el archivo .env (se usa el primero que exista, en este orden):
    //  1) la raiz del proyecto   2) la carpeta de arriba (fuera de la zona publica, lo mas seguro en un hosting)
    //  3) includes/ (compatibilidad con la version anterior)
    //las variables reales del servidor (Heroku, Railway, Render...) tienen prioridad sobre el .env
    $dotenv=Dotenv\Dotenv::createImmutable([__DIR__.'/..',dirname(__DIR__,2),__DIR__]);
    $dotenv->safeLoad();

    require __DIR__.'/funciones.php';
    require __DIR__.'/config/database.php';

    //solo con APP_DEBUG=true en el .env los errores se muestran en pantalla (unicamente para desarrollo)
    if(env('APP_DEBUG')==='true'){
        ini_set('display_errors','1');
    }
   
    use Model\ActiveRecord;
    $db=conexionDataBase();
    //pasa la conexion de la base de datos atraves del metodo estatico de la clase propiedad
    ActiveRecord::setDb($db);
