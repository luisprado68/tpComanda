<?php

namespace Apps\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use Apps\models\Comida;
use Apps\models\validar;

class ComidaController{

    public function getAll(Request $request, Response $response, $args) {

        
        $respuesta = Comida::get();
        
        $response->getBody()->write(json_encode($respuesta));
        return $response;
    }

    public function getOne(Request $request, Response $response, $args) {

        
        $respuesta = Comida::where('id',$args['id'])->get();
        
        $response->getBody()->write(json_encode($respuesta));
        return $response;
    }

    public function addOne(Request $request, Response $response, $args) {

        
        $comida = new Comida;

        $comida->nombre = $_POST['nombre'] ?? '';
        $comida->precio = $_POST['precio'] ?? '';
        $comida->tiempo = $_POST['tiempo'] ?? '';
      
        $respuesta =$comida->save();

        $response->getBody()->write(json_encode($respuesta));
        return $response;
    }

    public function updateOne(Request $request, Response $response, $args) {

         $usuarioObj = Comida::where('legajo',$args['legajo'])->first();
       
      
        if($usuarioObj->tipo == "alumno"){
            $email = $_POST['email'] ?? '';

            $usuario = Comida::find($usuarioObj->id);
            $usuario->email = $email;
            $respuesta =$usuario->update();
        $response->getBody()->write(json_encode($respuesta));
        return $response;
         }
        
        
    }

    public function deleteOne(Request $request, Response $response, $args) {

        $usuarioObj = Comida::where('legajo',$args['legajo'])->first();
       
      
        
        $usuario = Comida::find($usuarioObj->id);

        $respuesta =$usuario->delete();
    
        $response->getBody()->write(json_encode($respuesta));
        return $response;
    }

    
}