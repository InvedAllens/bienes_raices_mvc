<?php 
    namespace Model;
    class Admin extends ActiveRecord{
        protected static $tabla='usuarios';
        protected static $columnasDb=['id','email','password'];
        public $id;
        public $email;
        public $password;

        public function __construct($args=[])
        {
            $this->id=$args['id'] ?? null;
            $this->email=$args['email'];
            $this->password=$args['password'];
        }
        public function validar(){
            if(!$this->email){
                self::$errores[]='El email es obligatorio';
            }
            if(!$this->password){
                self::$errores[]='El password es obligatorio';
            }
        }
        public function validarUsuario(){
            $query="SELECT * FROM usuarios WHERE email='".$this->email."' LIMIT 1";
            $usuario=self::$db->query($query);
            if(!$usuario->num_rows){
                self::$errores[]='el usuario no existe';
                return;
            }else{
                return $usuario;
            }

        }
        public function validarPassword($resultado){
            //asignamos al usuario(resultado) encontrado en la base de datos a una nueva variable como objeto
            $usuario=$resultado->fetch_object();
            $autenticado=password_verify($this->password,$usuario->password);
            if(!$autenticado){
                self::$errores[]='El password es incorrecto';
            }else{
                return $autenticado;
            }
            
            
        }
        public function autenticar(){
            //inicio de sesion
            session_start();
            //llenado del arreglo de la session
            $_SESSION['usuario']=$this->email;
            $_SESSION['login']=true;
            //redirigiendo a admin
            header('Location:/admin');
        }

    }