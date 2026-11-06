<?php
    //Crea el usuario administrador (o cambia su password si el email ya existe).
    //Uso por terminal:   php database/crear-admin.php correo@ejemplo.com
    //(si no escribes la contraseña como segundo argumento, te la pide sin mostrarla en pantalla)
    if(PHP_SAPI!=='cli'){
        http_response_code(404);
        exit;
    }
    require __DIR__.'/../includes/app.php';   //carga el .env y abre la conexion ($db)

    $email=trim($argv[1] ?? '');
    if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
        fwrite(STDERR,"Uso: php database/crear-admin.php correo@ejemplo.com [password]\n");
        exit(1);
    }
    $password=$argv[2] ?? '';
    if($password===''){
        echo "Password para $email (minimo 8 caracteres): ";
        @shell_exec('stty -echo');
        $password=trim((string)fgets(STDIN));
        @shell_exec('stty echo');
        echo "\n";
    }
    if(strlen($password)<8){
        fwrite(STDERR,"El password debe tener al menos 8 caracteres.\n");
        exit(1);
    }

    $hash=password_hash($password,PASSWORD_BCRYPT);
    //si el email ya existe solo se actualiza su password
    $stmt=$db->prepare('INSERT INTO usuarios (email,password) VALUES (?,?) ON DUPLICATE KEY UPDATE password=VALUES(password)');
    $stmt->bind_param('ss',$email,$hash);
    $stmt->execute();
    echo $stmt->affected_rows===1 ? "Administrador creado: $email\n" : "Password actualizado para: $email\n";
