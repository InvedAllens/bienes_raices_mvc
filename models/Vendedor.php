<?php 
    namespace Model;
    
    class Vendedor extends ActiveRecord{

        protected static $tabla='vendedores';
        protected static $columnasDb=['idvendedor','nombre','apellido','telefono'];
        public $idvendedor;
        public $nombre;
        public $apellido;
        public $telefono;
        

        public function __construct($args=[])
        {
            $this->idvendedor=$args['idpropiedad'] ?? null;
            $this->nombre=$args['nombre'] ?? '';
            $this->apellido=$args['apellido'] ?? '';
            $this->telefono=$args['telefono'] ?? '';
            
        }

        public function validar(){
            if(!s($this->nombre) || s(strlen($this->nombre))>45){
                self::$errores[]='El nombre es obligatorio maximo 45 caracteres';
            }
            if(!s($this->apellido) || s(strlen($this->apellido))>45){
                self::$errores[]='El Apellido es obligatorio maximo 45 caracteres';
            }
            if(!s($this->telefono) || s(strlen($this->telefono))!=10 ||!preg_match(('/[0-9]{10}/'),s($this->telefono))){
                self::$errores[]='El teléfono es obligatorio debe contener 10 digitos';
            }
        }

    }