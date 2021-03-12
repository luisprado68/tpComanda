<?php

namespace Apps\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use Apps\models\Mesa;
use Apps\models\validar;

class MesaController{

    public function getAll(Request $request, Response $response, $args) {

        
        $mesas = Mesa::get();

        $response->getBody()->write(json_encode($mesas));
        return $response;
    }

    public function getOne(Request $request, Response $response, $args) {

        
        $respuesta = Mesa::where('id',$args['id'])->get();
        
        $response->getBody()->write(json_encode($respuesta));
        return $response;
    }

    public function addOne(Request $request, Response $response, $args) {

        
        $mesa = new Mesa;

        $mesa->marca = $_POST['id_estado'] ?? '';
        $mesa->tipo = $_POST['codigo'] ?? '';
        
      
        $respuesta =$mesa->save();

        $response->getBody()->write(json_encode($respuesta));
        return $response;
    }

    public function updateOne(Request $request, Response $response, $args) {

        $id_estado = $_POST['id_estado'];

        try {
            $mesa = Mesa::where('id',$args['id'])->firstOrFail();
       
      
            $mesa->id_estado=$id_estado;
            $respuesta = $mesa->save();
            $response->getBody()->write(json_encode($respuesta));

        } catch (\Throwable $th) {
           echo "Mesa no disponible .";;
        }

         
        return $response;
         
        
        
    }

    public function deleteOne(Request $request, Response $response, $args) {

        $usuarioObj = Mesa::where('legajo',$args['legajo'])->first();
       
      
        
        $usuario = Mesa::find($usuarioObj->id);

        $respuesta =$usuario->delete();
    
        $response->getBody()->write(json_encode($respuesta));
        return $response;
    }

    
}