<?php 
    namespace Model;
class Propiedad extends ActiveRecord{
    protected static $tabla='propiedades';
    protected static $columnaId='idpropiedad';
    protected static $columnasDb=['idpropiedad','titulo','precio','imagen','descripcion','habitaciones','wc','estacionamiento','creado','vendedores_idvendedor'];
    public $idpropiedad;
    public $titulo;
    public $precio;
    public $imagen;
    public $descripcion;
    public $habitaciones;
    public $wc;
    public $estacionamiento;
    public $creado;
    public $vendedores_idvendedor;

        public function __construct($args=[])
        {
            $this->idpropiedad=$args['idpropiedad'] ?? null;
            $this->titulo=$args['titulo'] ?? '';
            $this->precio=$args['precio'] ?? '';
            $this->imagen=$args['imagen'] ?? '';
            $this->descripcion=$args['descripcion'] ?? '';
            $this->habitaciones=$args['habitaciones'] ?? '';
            $this->wc=$args['wc'] ?? '';
            $this->estacionamiento=$args['estacionamiento'] ?? '';
            $this->creado=date('Y-m-d');
            $this->vendedores_idvendedor=$args['vendedores_idvendedor'] ?? '';
        }

        //un entero positivo de 1 a 9 (los mismos limites que tienen los campos del formulario)
        private static function enteroValido($valor){
            $valor=(string)$valor;
            return ctype_digit($valor) && (int)$valor>=1 && (int)$valor<=9;
        }

        public function validar(){
            parent::validar();
            $titulo=trim((string)$this->titulo);
            if($titulo==='' || mb_strlen($titulo)>45){
                self::$errores[]='debes de añadir un titulo maximo 45 caracteres';
            }
            if(!is_numeric($this->precio) || (float)$this->precio<=0 || (float)$this->precio>99999999){
                self::$errores[]='Debes de añadir un precio valido (solo numeros)';
            }
            if(mb_strlen(trim((string)$this->descripcion))<70){
                self::$errores[]='La descripcion debe contener almenos 70 caracteres';
            }
            if(!self::enteroValido($this->habitaciones)){
                self::$errores[]='El numero de habitaciones es obligatorio (de 1 a 9)';
            }
            if(!self::enteroValido($this->wc)){
                self::$errores[]='El numero de baños es obligatorio (de 1 a 9)';
            }
            if(!self::enteroValido($this->estacionamiento)){
                self::$errores[]='El numero de lugares de estacionamiento es obligatorio (de 1 a 9)';
            }
            $vendedor=(string)$this->vendedores_idvendedor;
            if(!ctype_digit($vendedor) || !Vendedor::find($vendedor)){
                self::$errores[]='Elije un vendedor';
            }
            if(!$this->imagen){
                self::$errores[]='La imagen de la propiedad es obligatoria';
            }
    
            
        }

}
