<?php

namespace Apps\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use Apps\models\EstadosMesa;
use Apps\models\validar;

class EstadosMesaController{

    public function getAll(Request $request, Response $response, $args) {

        
        $respuesta = EstadosMesa::get();
        
        $response->getBody()->write(json_encode($respuesta));
        return $response;
    }

    public function getOne(Request $request, Response $response, $args) {

        
        $respuesta = EstadosMesa::where('id',$args['id'])->get();
        
        $response->getBody()->write(json_encode($respuesta));
        return $response;
    }

    public function addOne(Request $request, Response $response, $args) {

        
        $bebida = new EstadosMesa;

        $bebida->marca = $_POST['marca'] ?? '';
        $bebida->tipo = $_POST['tipo'] ?? '';
        $bebida->precio = $_POST['precio'] ?? '';
      
        $respuesta =$bebida->save();

        $response->getBody()->write(json_encode($respuesta));
        return $response;
    }

    public function updateOne(Request $request, Response $response, $args) {

         $usuarioObj = EstadosMesa::where('legajo',$args['legajo'])->first();
       
      
        if($usuarioObj->tipo == "alumno"){
            $email = $_POST['email'] ?? '';

            $usuario = EstadosMesa::find($usuarioObj->id);
            $usuario->email = $email;
            $respuesta =$usuario->update();
        $response->getBody()->write(json_encode($respuesta));
        return $response;
         }
        
        
    }

    public function deleteOne(Request $request, Response $response, $args) {

        $usuarioObj = EstadosMesa::where('legajo',$args['legajo'])->first();
       
      
        
        $usuario = EstadosMesa::find($usuarioObj->id);

        $respuesta =$usuario->delete();
    
        $response->getBody()->write(json_encode($respuesta));
        return $response;
    }

    
}