<?php 
    if(!isset($_SESSION)){
        session_start();
    }
    $auth=$_SESSION['login'] ?? false;
    if(!isset($inicio)){
        $inicio=false;
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienes Raices</title>
    <link rel="stylesheet" href="<?php echo BASE_PATH; ?>/build/css/app.css">
</head>
<body>
    <header class="header <?php echo $inicio ? 'inicio':''; ?>">
        <div class="contenedor contenido-header ">
            <div class="barra">
                <a href="<?php echo BASE_PATH; ?>/index">
                    <img src="<?php echo BASE_PATH; ?>/build/img/logo.svg" alt="logo de la empresa">
                </a>
                <div class="menu-mobil">
                    <img src="<?php echo BASE_PATH; ?>/build/img/barras.svg" alt="icono menu de hamburguesa">
                </div>
                <div class="barra-derecha">
                    <img class="boton-dark-mode" src="" alt="boton dark mode">
                    <nav class="navegacion mostrar">
                        <a href="<?php echo BASE_PATH; ?>/nosotros">Nosotros</a>
                        <a href="<?php echo BASE_PATH; ?>/anuncios">Anuncios</a>
                        <a href="<?php echo BASE_PATH; ?>/blog">Blog</a>
                        <a href="<?php echo BASE_PATH; ?>/contacto">Contacto</a>
                        <?php if($auth):?>
                            <a href="<?php echo BASE_PATH; ?>/logout">Cerrar Sesion</a>
                        <?php endif;?>
                    </nav><!--Navegacion-->
                </div>
                
            </div><!--Barra-->
            <?php if($inicio) { ?>
                <h1>Venta de casas y Departamentos exclusivos de lujo</h1>
            <?php } ?>
        </div>
    </header>
    
    <?php 
     echo $contenido;             
                ?>
    <footer class="footer seccion">
        <div class="contenedor-footer contenedor">
            <nav class="navegacion">
                <a href="<?php echo BASE_PATH; ?>/nosotros">Nosotros</a>
                <a href="<?php echo BASE_PATH; ?>/anuncios">Anuncios</a>
                <a href="<?php echo BASE_PATH; ?>/blog">Blog</a>
                <a href="<?php echo BASE_PATH; ?>/contacto">Contacto</a>
            </nav>
            <p class="copyright">Todos los derechos reservados <?php echo date('Y'); ?> &copy;</p>
        </div>  
    </footer>
    
    <script>window.BASE_PATH=<?php echo json_encode(BASE_PATH,JSON_UNESCAPED_SLASHES); ?>;</script>
    <script src="<?php echo BASE_PATH; ?>/build/js/bundle.min.js"></script>
</body>
</html>