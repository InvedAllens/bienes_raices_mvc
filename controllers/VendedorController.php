<?php 
    
    namespace Controllers;
    use MVC\Router;
    use Model\Vendedor;

    class VendedorController{

        //unicos campos del formulario que se copian al vendedor (nunca el id)
        private const CAMPOS=['nombre','apellido','telefono'];

        public static function crear(Router $router){
            $vendedor=new Vendedor;
            $errores=[];
            if($_SERVER['REQUEST_METHOD']==='POST'){
                $args=$_POST['vendedor'] ?? [];
                $vendedor=new Vendedor();
                $vendedor->sincronizar(is_array($args) ? $args : [],self::CAMPOS);
                $vendedor->validar();
                $errores=Vendedor::getErrores();
                if(empty($errores)){
        
                    $resultado=$vendedor->guardar();
                    if($resultado){
                        header('Location:'.url('/admin?resultado=1'));
                        exit;
                    }
                    $errores[]='No se pudieron guardar los datos';
        
                }
               
            }
            $router->render("vendedores/crear",
                            ["vendedor"=>$vendedor,
                            "errores"=>$errores
                        ]);
        }
        public static function actualizar(Router $router){
            $id=filter_var($_GET['id'] ?? null,FILTER_VALIDATE_INT);
            $vendedor=$id ? Vendedor::find($id) : false;
            //si no existe el vendedor se regresa al panel y se DETIENE la ejecucion
            if(!$vendedor){
                header('Location:'.url('/admin'));
                exit;
            }
            $errores=[];
            if($_SERVER['REQUEST_METHOD']==='POST'){
                $args=$_POST['vendedor'] ?? [];
                $vendedor->sincronizar(is_array($args) ? $args : [],self::CAMPOS);
                $vendedor->validar();
                $errores=Vendedor::getErrores();
                if(empty($errores)){
                    $resultado=$vendedor->actualizar();
                    if($resultado){
                        header('Location:'.url('/admin?resultado=2'));
                        exit;
                    }
                    $errores[]='No se pudieron actualizar los datos';
                }
            }
            $router->render("vendedores/actualizar",
                            ["vendedor"=>$vendedor,
                             "errores"=>$errores
                        ]);
        }

    }
