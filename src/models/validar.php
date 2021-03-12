<?php
    namespace Apps\models;
    use \Firebase\JWT\JWT;
    //usamos la clase model para la conexion de base
    use Illuminate\Database\Eloquent\Model;
    
    class Validar extends Model{

        public static $token;

        public static function generarJWT($payload){
                $clave = "segundoParcial";
                $jwt = JWT::encode($payload, $clave);
                return $jwt;
            }
        
        
        public static function validarJWT($token){
            $logueado=null;
            $clave="segundoParcial";
            try {
                //recibo y paso token clave y el algoritmo para decodificar
                $logueado = JWT::decode($token, $clave, array('HS256'));
            
                //print_r($decoded);//devuelve un standar class
    
            } catch (\Throwable $th) {
    
                $logueado=null;
            }
    
            return $logueado;
        }
        
        public static function validarTipo($decoded,$tipo){
            $array= (array)$decoded;
            $ok=false;
            foreach ($array as  $key => $value) {
                if($value == $tipo){
                    $ok=true;
                    break;
                }
            }
            return $ok;
        }
        
        public static function obtenerIdUsuario($decoded){

            $array= (array)$decoded;
            $id=0;
            foreach ($array as  $key => $value) {
                $id=$value;
                break;
            }
            return $id;
        }
    }
    

?>