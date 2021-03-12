<?php

namespace Apps\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use Apps\models\Ingreso;
use Apps\models\Usuario;
use Apps\models\validar;

class IngresoController{

    public function getAll(Request $request, Response $response, $args) {

        
        $respuesta = Ingreso::get();
        
        $response->getBody()->write(json_encode($respuesta));
        return $response;
    }

    public function getOne(Request $request, Response $response, $args) {

        
        $respuesta = Ingreso::where('id',$args['id'])->get();
        
        $response->getBody()->write(json_encode($respuesta));
        return $response;
    }

    public function addOne(Request $request, Response $response, $args) {

        date_default_timezone_set('America/Argentina/Buenos_Aires');
        
        $encontro =false;

        $email = $_POST['email'] ?? '';
        $clave = $_POST['clave'] ?? '';

        $tipo="";

        try {
            $usuario = Usuario::where('clave',$clave)->where('email',$email)->firstOrFail();
            // $response->getBody()->write(json_encode($respuesta));
            $tipo=$usuario->tipo;
            $id=$usuario->id;
            $ingreso = new Ingreso;

            $ingreso->id_usuario = $usuario->id;
            $ingreso->fecha_ingreso = date("Y-m-d H:i:s");
            $respuesta =$ingreso->save();
            
            $payload = array(
                "id" => $id,
                "email" => $email,
                "tipo" => $tipo,
                
            );
            echo Validar ::generarJWT($payload)."\n";
        } 
        catch (\Throwable $th) {
            echo "El usuario no existe.";
        }

            $response->getBody()->write(json_encode($respuesta));
            return $response;
       
    }

    public function updateOne(Request $request, Response $response, $args) {

         $usuarioObj = Ingreso::where('legajo',$args['legajo'])->first();
       
      
        if($usuarioObj->tipo == "alumno"){
            $email = $_POST['email'] ?? '';

            $usuario = Ingreso::find($usuarioObj->id);
            $usuario->email = $email;
            $respuesta =$usuario->update();
        $response->getBody()->write(json_encode($respuesta));
        return $response;
         }
        
        
    }

    public function deleteOne(Request $request, Response $response, $args) {

        $usuarioObj = Ingreso::where('legajo',$args['legajo'])->first();
       
      
        
        $usuario = Ingreso::find($usuarioObj->id);

        $respuesta =$usuario->delete();
    
        $response->getBody()->write(json_encode($respuesta));
        return $response;
    }

    
}