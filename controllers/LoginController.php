<?php 
    namespace Controllers;
    use Model\Admin;
    use MVC\Router;
    class LoginController{

        public static function login(Router $router){
            $admin=new Admin();
            $errores=[];
            if($_SERVER['REQUEST_METHOD']==='POST'){
                $auth=new Admin($_POST);
                $auth->validar();
                $errores=Admin::getErrores();
                // debugear($admin);
                if(empty($errores)){
                    //verificamos que existe el usuario
                    $usuario=$auth->validarUsuario();
                    if(!$usuario){
                        $errores=Admin::getErrores();
                    }else{
                        //verificamos el password
                        $authenticado=$auth->validarPassword($usuario);
                        if(!$authenticado){
                            //si no esta authenticado obtenemos el arreglo de errores actualizado
                            $errores=Admin::getErrores();
                        }else{
                            //si esta authenticado llamamos a la funcion autenticar para inicia session y definir parametros
                            $auth->autenticar();
                        }

                    }

                }
            }
            $router->render("auth/login",["errores"=>$errores,"auth"=>$auth]);
        }
        public static function logout(){
            session_start();
            $_SESSION=[];
            header('Location:/index');
        }

    }
