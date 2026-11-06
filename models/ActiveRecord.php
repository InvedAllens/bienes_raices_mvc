<?php 
    
    namespace Model;

    class ActiveRecord{

        protected static $db;
        protected static $columnasDb=[];
        protected static $errores=[];
        protected static $tabla='';
        //nombre de la columna llave primaria de la tabla (cada modelo define la suya)
        protected static $columnaId='id';
       
        public $imagen;

        //convierte un valor ya sanitizado en texto para la consulta (null => NULL)
        protected static function valorSql($valor){
            return is_null($valor) ? 'NULL' : "'".$valor."'";
        }
        //escapa un valor para poder usarlo con seguridad dentro de una consulta
        protected static function escapar($valor){
            return self::$db->escape_string((string)$valor);
        }
        
        public function guardar(){
            //sanitizar datos
            $sanitizados=$this->sanitizar();
            
            //consulta a la base de datos: INSERT INTO tabla (col1,col2) VALUES ('v1','v2')
            $valores=[];
            foreach($sanitizados as $valor){
                $valores[]=static::valorSql($valor);
            }
            $query="INSERT INTO ".static::$tabla." (";
            // join convierte a string el array, el pimer parametro es la separacion el segundo el array
            // array_keys solo obtiene las llaves
            $query.=join(",",array_keys($sanitizados));
            $query.=") VALUES (";
            $query.=join(",",$valores);
            $query.=")";

            //primero accedemos a la propiedad estatica, que ya ha sido establecida desde app.php con el metodo publico estatico
            //setDb, se le asigno la conexion o un objeto de la clase mysqli con las credenciales de la conexion
            $resultado=self::$db->query($query);
            return $resultado;
        }
        //elimina el registro de la base de datos. Devuelve true/false (las redirecciones y el borrado de
        //la imagen le corresponden al controlador)
        public function eliminar(){
            $id=static::escapar($this->{static::$columnaId});
            $consultaEliminar="DELETE FROM ".static::$tabla." WHERE ".static::$columnaId."='".$id."' LIMIT 1";
            return self::$db->query($consultaEliminar);
        }
        //funcion estatica publica para establecer la conexion con la base de ddtos, en este proyecto es establecida 
        //desde app.php 
        public static function setDb($database){
            self::$db=$database;
        }
        //funcion para copiar las propiedades del objeto en un array(propiedad y valor), se utilizara para otras funciones como sanitizar
        public function atributos(){
            $atributos=[];
            foreach(static::$columnasDb as $columna):
                if($columna===static::$columnaId){continue;}
                $atributos[$columna]=$this->$columna;
            endforeach;
            return $atributos;
        }
        //funcion que sanitiza los valores para evitar inyecciones sql(escapa todos los caracteres que podrian afectar una sentencia sql)
        public function sanitizar(){
            $sanitizados=[];
            foreach($this->atributos() as $key=>$value):
                $sanitizados[$key]=is_null($value) ? null : static::escapar($value);
            endforeach;
            return $sanitizados;
        }
        //funcion para obtener los errores
        public static function getErrores(){
           return static::$errores;
        }
        //funcion para validar los valores de los atributos del objeto
        public function validar(){
           static::$errores=[];
                
        }
        //asigna el nombre de la nueva imagen al atributo imagen (el archivo anterior lo borra el controlador
        //DESPUES de guardar los cambios, para no perder la foto si algo falla)
        public function setImagen($imagen){
            if($imagen){
                $this->imagen=$imagen;
            }
        }
        //funcion estatica para obtener todos los registros de propiedadades
        public static function all(){
            $query="SELECT * FROM ".static::$tabla;
            $resultado=self::consultaSQL($query);
            return $resultado;
        }
        //funcion estatica para obtener un numero determinado de propiedadades
        public static function get($cantidad){
            $query="SELECT * FROM ".static::$tabla." LIMIT ".(int)$cantidad;
            $resultado=self::consultaSQL($query);
            return $resultado;
        }
        //funcion estatica y protected para consultar en la base de datos
        protected static function consultaSQL($query){
            $resConsulta=self::$db->query($query);
            $array=[];
            if(!$resConsulta){
                return $array;
            }
            while($registro=$resConsulta->fetch_assoc()):
                $array[]=static::crearObjeto($registro);
            endwhile;
            //liberar memoria
            $resConsulta->free();

            return $array;
            
        }
        //convierte un arreglo en un objeto 
        protected static function crearObjeto($array){
            $instancia=new static;
            foreach($array as $key=>$value):
                if(property_exists($instancia,$key)):
                    $instancia->$key=$value;
                endif;
            endforeach;
            return $instancia;
        }

        //busca un registro por su llave primaria. Devuelve el objeto o false si no existe
        public static function find($id){
           $query="SELECT * FROM ".static::$tabla." WHERE ".static::$columnaId."='".static::escapar($id)."' LIMIT 1";
           $resultado=self::consultaSQL($query);
           return  current($resultado);            
        }
        //busca el primer registro cuyo campo tenga ese valor. Devuelve el objeto o false
        public static function where($campo,$valor){
            //el nombre del campo no se puede escapar como un valor, asi que solo se aceptan columnas del modelo
            if(!in_array($campo,static::$columnasDb,true)){
                throw new \InvalidArgumentException("Columna no valida: ".$campo);
            }
            $query="SELECT * FROM ".static::$tabla." WHERE ".$campo."='".static::escapar($valor)."' LIMIT 1";
            $resultado=self::consultaSQL($query);
            return current($resultado);
        }
        //copia los datos recibidos al objeto. NO escapa nada (eso lo hace sanitizar al guardar).
        //$permitidos limita que campos se pueden asignar: asi nadie puede enviar por ejemplo idpropiedad
        //en un formulario para modificar otro registro
        public function sincronizar($args,$permitidos=null){
            foreach($args as $key=>$value):
                if(is_array($permitidos) && !in_array($key,$permitidos,true)){
                    continue;
                }
                if(property_exists($this,$key) && is_scalar($value)):
                    $this->$key=$value;
                endif;
            endforeach;
            return $this;
        }
        public function actualizar(){
            //primero hay que sanitizar los datos denuevo
            $sanitizados=$this->sanitizar();
            $valoresSet=[];
            foreach($sanitizados as $key=>$value):
                $valoresSet[]=$key."=".static::valorSql($value);
            endforeach;
            $query="UPDATE ".static::$tabla." SET ";
            $query.=join(",",$valoresSet);
            $query.=" WHERE ".static::$columnaId."='".static::escapar($this->{static::$columnaId})."'";
            $query.=" LIMIT 1";
            $resultado=self::$db->query($query);            
            return $resultado;
        }
    }
