<?php 
    namespace Model;
    class Admin extends ActiveRecord{
        protected static $tabla='usuarios';
        protected static $columnaId='id';
        protected static $columnasDb=['id','email','password'];
        public $id;
        public $email;
        public $password;

        public function __construct($args=[])
        {
            $this->id=$args['id'] ?? null;
            $this->email=(string)($args['email'] ?? '');
            $this->password=(string)($args['password'] ?? '');
        }
        public function validar(){
            parent::validar();
            if(!$this->email){
                self::$errores[]='El email es obligatorio';
            }
            if(!$this->password){
                self::$errores[]='El password es obligatorio';
            }
        }
        //busca al usuario por su email (consulta escapada). Devuelve el usuario encontrado o null
        public function validarUsuario(){
            $usuario=self::where('email',$this->email);
            if(!$usuario){
                self::$errores[]='el usuario no existe';
                return null;
            }
            return $usuario;

        }
        //compara el password escrito con el hash guardado del usuario encontrado
        public function validarPassword($usuario){
            $autenticado=password_verify($this->password,(string)$usuario->password);
            if(!$autenticado){
                self::$errores[]='El password es incorrecto';
            }
            return $autenticado;
        }
        public function autenticar(){
            //la sesion ya fue iniciada por el Router; se genera un nuevo id al iniciar sesion (evita el robo de sesiones)
            session_regenerate_id(true);
            //llenado del arreglo de la session
            $_SESSION['usuario']=$this->email;
            $_SESSION['login']=true;
            //redirigiendo a admin y DETENIENDO la ejecucion
            header('Location:'.url('/admin'));
            exit;
        }

    }
