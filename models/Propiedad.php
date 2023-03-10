<?php 
    namespace Model;
class Propiedad extends ActiveRecord{
    protected static $tabla='propiedades';
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
            $this->creado=date('Y,m,d');
            $this->vendedores_idvendedor=$args['vendedores_idvendedor'] ?? '';
        }

        public function validar(){
            if(!s($this->titulo) || s(strlen($this->titulo))>45){
                self::$errores[]='debes de añadir un titulo maximo 45 caracteres';
            }
            if(!s($this->precio)){
                self::$errores[]='Debes de añadir un precio';
            }
            if(s(strlen($this->descripcion)<70)){
                self::$errores[]='La descripcion debe contener almenos 70 caracteres';
            }
            if(!s($this->habitaciones)){
                self::$errores[]='El numero de habitaciones es obligatorio';
            }
            if(!s($this->wc)){
                self::$errores[]='El numero de baños es obligatorio';
            }
            if(!s($this->estacionamiento)){
                self::$errores[]='El numero de lugares de estacionamiento es obligatorio';
            }
            if(!s($this->vendedores_idvendedor)){
                self::$errores[]='Elije un vendedor';
            }
            if(!s($this->imagen)){
                self::$errores[]='La imagen de la propiedad es obligatoria';
            }
    
            
        }

}
  
