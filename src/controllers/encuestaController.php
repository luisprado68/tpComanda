<?php

namespace Apps\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use Apps\models\Encuesta;
use Apps\models\validar;

class EncuestaController{

    public function getAll(Request $request, Response $response, $args) {

        
        $respuesta = Encuesta::get();
        
        $response->getBody()->write(json_encode($respuesta));
        return $response;
    }

    public function getMejorComentario(Request $request, Response $response, $args) {

        $mesa = Encuesta::max('mesa');
        $mozo = Encuesta::max('mozo');
        $restaurante = Encuesta::max('restaurante');
        $encuesta = Encuesta::where('mesa',$mesa)->where('mozo',$mozo)->where('restaurante',$restaurante)->get();
        
        
        $response->getBody()->write(json_encode($encuesta));
        return $response;
    }

    public function addOne(Request $request, Response $response, $args) {

        
        $encuesta = new Encuesta;

        $encuesta->mesa = $_POST['mesa'] ?? '';
        $encuesta->restaurante = $_POST['restaurante'] ?? '';
        $encuesta->mozo = $_POST['mozo'] ?? '';
        $encuesta->experiencia = $_POST['experiencia'] ?? '';
        $respuesta =$encuesta->save();

        $response->getBody()->write(json_encode($respuesta));
        return $response;
    }

    public function updateOne(Request $request, Response $response, $args) {

         $usuarioObj = Encuesta::where('legajo',$args['legajo'])->first();
       
      
        if($usuarioObj->tipo == "alumno"){
            $email = $_POST['email'] ?? '';

            $usuario = Encuesta::find($usuarioObj->id);
            $usuario->email = $email;
            $respuesta =$usuario->update();
        $response->getBody()->write(json_encode($respuesta));
        return $response;
         }
        
        
    }

    public function deleteOne(Request $request, Response $response, $args) {

        $usuarioObj = Encuesta::where('legajo',$args['legajo'])->first();
       
      
        
        $usuario = Encuesta::find($usuarioObj->id);

        $respuesta =$usuario->delete();
    
        $response->getBody()->write(json_encode($respuesta));
        return $response;
    }

    
}