<?php

namespace Apps\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use Apps\models\Cliente;
use Apps\models\validar;

class ClienteController{

    public function getAll(Request $request, Response $response, $args) {

        
        $respuesta = Cliente::get();
        
        $response->getBody()->write(json_encode($respuesta));
        return $response;
    }

    public function getOne(Request $request, Response $response, $args) {

        
        $respuesta = Cliente::where('id',$args['id'])->get();
        
        $response->getBody()->write(json_encode($respuesta));
        return $response;
    }

    public function addOne(Request $request, Response $response, $args) {

        
        $cliente = new Cliente;

        $cliente->nombre = $_POST['nombre'] ?? '';
       
      
        $respuesta =$cliente->save();

        $response->getBody()->write(json_encode($respuesta));
        return $response;
    }

    public function updateOne(Request $request, Response $response, $args) {

         $usuarioObj = Cliente::where('legajo',$args['legajo'])->first();
       
      
        if($usuarioObj->tipo == "alumno"){
            $email = $_POST['email'] ?? '';

            $usuario = Cliente::find($usuarioObj->id);
            $usuario->email = $email;
            $respuesta =$usuario->update();
        $response->getBody()->write(json_encode($respuesta));
        return $response;
         }
        
        
    }

    public function deleteOne(Request $request, Response $response, $args) {

        $usuarioObj = Cliente::where('legajo',$args['legajo'])->first();
       
      
        
        $usuario = Cliente::find($usuarioObj->id);

        $respuesta =$usuario->delete();
    
        $response->getBody()->write(json_encode($respuesta));
        return $response;
    }

    
}