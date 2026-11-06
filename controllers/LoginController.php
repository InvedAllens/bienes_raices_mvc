<?php 
    namespace Controllers;
    use Model\Admin;
    use MVC\Router;
    class LoginController{

        public static function login(Router $router){
            $auth=new Admin();
            $errores=[];
            if($_SERVER['REQUEST_METHOD']==='POST'){
                $auth=new Admin($_POST);
                $auth->validar();
                $errores=Admin::getErrores();
                if(empty($errores)){
                    //verificamos que existe el usuario
                    $usuario=$auth->validarUsuario();
                    if(!$usuario){
                        $errores=Admin::getErrores();
                    }else{
                        //verificamos el password
                        if($auth->validarPassword($usuario)){
                            //si esta authenticado llamamos a la funcion autenticar para inicia session y redirigir
                            $auth->autenticar();
                        }
                        //si no esta authenticado obtenemos el arreglo de errores actualizado
                        $errores=Admin::getErrores();
                    }

                }
            }
            $router->render("auth/login",["errores"=>$errores,"auth"=>$auth]);
        }
        public static function logout(){
            $_SESSION=[];
            session_destroy();
            header('Location:'.url('/index'));
            exit;
        }

    }
