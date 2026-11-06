<?php 
    namespace Model;
    
    class Vendedor extends ActiveRecord{

        protected static $tabla='vendedores';
        protected static $columnaId='idvendedor';
        protected static $columnasDb=['idvendedor','nombre','apellido','telefono'];
        public $idvendedor;
        public $nombre;
        public $apellido;
        public $telefono;
        

        public function __construct($args=[])
        {
            $this->idvendedor=$args['idvendedor'] ?? null;
            $this->nombre=$args['nombre'] ?? '';
            $this->apellido=$args['apellido'] ?? '';
            $this->telefono=$args['telefono'] ?? '';
            
        }

        public function validar(){
            parent::validar();
            $nombre=trim((string)$this->nombre);
            $apellido=trim((string)$this->apellido);
            if($nombre==='' || mb_strlen($nombre)>45){
                self::$errores[]='El nombre es obligatorio maximo 45 caracteres';
            }
            if($apellido==='' || mb_strlen($apellido)>45){
                self::$errores[]='El Apellido es obligatorio maximo 45 caracteres';
            }
            if(!preg_match('/^[0-9]{10}$/',(string)$this->telefono)){
                self::$errores[]='El teléfono es obligatorio debe contener 10 digitos';
            }
        }

    }
