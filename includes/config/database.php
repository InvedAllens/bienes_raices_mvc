<?php
    
    function conexionDataBase() : mysqli{
        //los errores de mysqli se lanzan como excepciones (mismo comportamiento en PHP 7.4 y 8.x)
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        try{
            $db=new mysqli(
                env('DB_HOST','localhost'),
                env('DB_USER'),
                env('DB_PASS'),
                env('DB_BD'),
                (int) env('DB_PORT',3306)
            );
            $db->set_charset('utf8mb4');
            return $db;
        }catch(mysqli_sql_exception $e){
            //el detalle real solo va al log, nunca se le muestra al visitante
            error_log('[BienesRaices] No se pudo conectar a MySQL: '.$e->getMessage());
            http_response_code(500);
            echo 'No se pudo conectar a la base de datos.';
            if(env('APP_DEBUG')==='true'){
                echo ' '.htmlspecialchars($e->getMessage());
            }
            exit;
        }
    }
