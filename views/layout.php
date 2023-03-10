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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienes Raices</title>
    <link rel="stylesheet" href="/build/css/app.css">
</head>
<body>
    <header class="header <?php echo $inicio ? 'inicio':''; ?>">
        <div class="contenedor contenido-header ">
            <div class="barra">
                <a href="/index">
                    <img src="/build/img/logo.svg" alt="logo de la empresa">
                </a>
                <div class="menu-mobil">
                    <img src="/build/img/barras.svg" alt="icono menu de hamburguesa">
                </div>
                <div class="barra-derecha">
                    <img class="boton-dark-mode" src="" alt="boton dark mode">
                    <nav class="navegacion mostrar">
                        <a href="/nosotros">Nosotros</a>
                        <a href="/anuncios">Anuncios</a>
                        <a href="/blog">Blog</a>
                        <a href="/contacto">Contacto</a>
                        <?php if($auth):?>
                            <a href="/logout">Cerrar Sesion</a>
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
                <a href="/nosotros">Nosotros</a>
                <a href="/anuncios">Anuncios</a>
                <a href="/blog">Blog</a>
                <a href="/contacto">Contacto</a>
            </nav>
            <p class="copyright">Todos los derechos reservados <?php echo date('Y'); ?> &copy;</p>
        </div>  
    </footer>
    
    <script src="/build/js/bundle.min.js"></script>
</body>
</html>