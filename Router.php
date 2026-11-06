<?php 
    namespace MVC;

    class Router{
        public $rutasGET=[];
        public $rutasPOST=[];
        //rutas que requieren haber iniciado sesion (administrador)
        protected $rutasProtegidas=['/admin','/propiedades/crear','/propiedades/actualizar','/vendedores/crear',
                                    '/vendedores/actualizar',
                                ];
        
        //establece una funcion para una url (esto para un metodo get/cargar pagina )
        public function get($url,$fn){
            $this->rutasGET[$url]=$fn;
        }
        public function post($url,$fn){
            $this->rutasPOST[$url]=$fn;
        }

        //inicia la sesion una sola vez, con una cookie mas segura
        protected function iniciarSesion(){
            if(session_status()===PHP_SESSION_NONE){
                $https=(!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS']!=='off')
                    || (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '')==='https');
                //cada app usa su PROPIA cookie de sesion: si dos apps comparten dominio y usaran la misma (PHPSESSID),
                //la sesion de una (por ejemplo un cliente de otra app) valdria tambien en esta
                session_name('bienesraices_sid');
                session_set_cookie_params([
                    'path'=>BASE_PATH==='' ? '/' : BASE_PATH,
                    'httponly'=>true,
                    'secure'=>$https,
                    'samesite'=>'Lax'
                ]);
                session_start();
            }
        }

        //devuelve solo la ruta (sin ?parametros), por ejemplo /anuncio?id=3 => /anuncio
        //la raiz del sitio (/) muestra la pagina de inicio
        protected function urlActual(){
            $path=parse_url($_SERVER['REQUEST_URI'] ?? '/',PHP_URL_PATH);
            if(!is_string($path) || $path===''){
                $path='/';
            }
            //si la app vive dentro de una ruta (/bienes-raices) se le quita para obtener la ruta interna (/anuncios)
            if(BASE_PATH!=='' && ($path===BASE_PATH || strpos($path,BASE_PATH.'/')===0)){
                $path=substr($path,strlen(BASE_PATH));
                if($path===''){ $path='/'; }
            }
            if($path!=='/'){
                $path=rtrim($path,'/');
                if($path===''){ $path='/'; }
            }
            return $path==='/' ? '/index' : $path;
        }

        //ejecuta las funciones dependiendo la url y el metodo asociado
        public function comprobarRutas(){
            $this->iniciarSesion();
            $autenticado=$_SESSION['login'] ?? null;
            $fn=null;
            //se obtienen la url (sin parametros) y el metodo a traves del server 
            $urlActual=$this->urlActual();
            $metodo=$_SERVER['REQUEST_METHOD'];

            //rutas de administrador: sin sesion se redirige al login y se DETIENE la ejecucion
            //(sin el exit el controlador seguia ejecutandose y cualquiera podia crear/borrar registros)
            if(in_array($urlActual,$this->rutasProtegidas,true) && !$autenticado){
                header('Location:'.url('/login'));
                exit;
            }

            //solo si es un metodo get, se obtiene la funcion del arreglo para ejecutarlo posteriormente
            if($metodo==='GET'){
                $fn=$this->rutasGET[$urlActual] ?? null;
            }elseif($metodo==='POST'){
                $fn=$this->rutasPOST[$urlActual] ?? null;
            }
            //si existe la url se utiliza un callback a la funcion asosciada a la url y metodo
            if($fn){
                call_user_func($fn,$this);
            }else{
                http_response_code(404);
                echo 'pagina no encontrada';
            }
        }
        public function render($view,$datos=[]){
            foreach($datos as $key=>$value):
                $$key=$value;
            endforeach;
            ob_start();
            include __DIR__."/views/$view.php";
            $contenido=ob_get_clean();
            include __DIR__.'/views/layout.php';
            
        }
    }
