<?php

namespace Apps\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use Apps\models\EstadosPedido;
use Apps\models\validar;

class EstadosPedidoController{

    public function getAll(Request $request, Response $response, $args) {

        
        $respuesta = EstadosPedido::get();
        
        $response->getBody()->write(json_encode($respuesta));
        return $response;
    }

   

    public function getOne(Request $request, Response $response, $args) {

        
        $respuesta = EstadosPedido::where('id',$args['id'])->get();
        
        $response->getBody()->write(json_encode($respuesta));
        return $response;
    }

    public function addOne(Request $request, Response $response, $args) {

        
        $bebida = new EstadosPedido;

        $bebida->marca = $_POST['marca'] ?? '';
        $bebida->tipo = $_POST['tipo'] ?? '';
        $bebida->precio = $_POST['precio'] ?? '';
      
        $respuesta =$bebida->save();

        $response->getBody()->write(json_encode($respuesta));
        return $response;
    }

    public function updateOne(Request $request, Response $response, $args) {

         $usuarioObj = EstadosPedido::where('legajo',$args['legajo'])->first();
       
      
        if($usuarioObj->tipo == "alumno"){
            $email = $_POST['email'] ?? '';

            $usuario = EstadosPedido::find($usuarioObj->id);
            $usuario->email = $email;
            $respuesta =$usuario->update();
        $response->getBody()->write(json_encode($respuesta));
        return $response;
         }
        
        
    }

    public function deleteOne(Request $request, Response $response, $args) {

        $usuarioObj = EstadosPedido::where('legajo',$args['legajo'])->first();
       
      
        
        $usuario = EstadosPedido::find($usuarioObj->id);

        $respuesta =$usuario->delete();
    
        $response->getBody()->write(json_encode($respuesta));
        return $response;
    }

    
}