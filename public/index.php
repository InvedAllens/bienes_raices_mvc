<?php

    use Model\Propiedad;
    use MVC\Router;
    use Controllers\PropiedadController;
    use Controllers\VendedorController;
    use Controllers\PaginasController;
    use Controllers\LoginController;

    require_once __DIR__.'/../includes/app.php';

    $router=new Router();
    //-------Rutas Protegidas---------------
    
    //asignacion de rutas para controlar propiedades
    $router->get('/admin',[PropiedadController::class,'index']);
    $router->get('/propiedades/crear',[PropiedadController::class,'crear']);
    $router->post('/propiedades/crear',[PropiedadController::class,'crear']);
    $router->get('/propiedades/actualizar',[PropiedadController::class,'actualizar']);
    $router->post('/propiedades/actualizar',[PropiedadController::class,'actualizar']);
    //asignacion de rutas para controlar vendedores
    $router->get('/vendedores/crear',[VendedorController::class,'crear']);
    $router->post('/vendedores/crear',[VendedorController::class,'crear']);
    $router->get('/vendedores/actualizar',[VendedorController::class,'actualizar']);
    $router->post('/vendedores/actualizar',[VendedorController::class,'actualizar']);
    //control del post en admin para eliminar registros(propiedades/vendedores)
    $router->post('/admin',[PropiedadController::class,'index']);
    
    //---------Paginas Publicas-----------

    $router->get('/index',[PaginasController::class,'index']);
    $router->get('/nosotros',[PaginasController::class,'nosotros']);
    $router->get('/anuncios',[PaginasController::class,'anuncios']);
    $router->get('/anuncio',[PaginasController::class,'anuncio']);
    $router->get('/blog',[PaginasController::class,'blog']);
    $router->get('/entrada',[PaginasController::class,'entrada']);
    $router->get('/contacto',[PaginasController::class,'contacto']);
    $router->post('/contacto',[PaginasController::class,'contacto']);

    //---------Login-----------
    $router->get('/login',[LoginController::class,'login']);
    $router->post('/login',[LoginController::class,'login']);
    $router->get('/logout',[LoginController::class,'logout']);
    


    $router->comprobarRutas();
