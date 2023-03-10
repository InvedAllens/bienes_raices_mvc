<?php 
    
    namespace Controllers;
    use MVC\Router;
    use Model\Vendedor;

    class VendedorController{

        public static function crear(Router $router){
            $vendedor=new Vendedor;
            $errores=Vendedor::getErrores();
            if($_SERVER['REQUEST_METHOD']==='POST'){
                // debugear($_POST['vendedor']);
                $vendedor=new Vendedor();
                $vendedor->sincronizar($_POST['vendedor']);
                // debugear($vendedor);
                $vendedor->validar();
                $errores=Vendedor::getErrores();
                if(empty($errores)){
        
                    $resultado=$vendedor->guardar();
                    if($resultado){
                        header('Location:/admin?resultado=1');
                    }
        
                }
               
            }
            $router->render("vendedores/crear",
                            ["vendedor"=>$vendedor,
                            "errores"=>$errores
                        ]);
        }
        public static function actualizar(Router $router){
            $id=$_GET['id'];
            $id=filter_var($id,FILTER_VALIDATE_INT);
            if($id){
                $vendedor=Vendedor::find($id);
            }else{
                header('Location:/admin');
            }
            $errores=Vendedor::getErrores();
            $vendedor=Vendedor::find($id);
            if($_SERVER['REQUEST_METHOD']==='POST'){
                $vendedor->sincronizar($_POST['vendedor']);
                $vendedor->validar();
                $errores=Vendedor::getErrores();
                if(empty($errores)){
                    $resultado=$vendedor->actualizar();
                    if($resultado){
                        header('Location:/admin?resultado=2');
                    }
                }
            }
            $router->render("vendedores/actualizar",
                            ["vendedor"=>$vendedor,
                             "errores"=>$errores
                        ]);
        }

    }