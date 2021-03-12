<?php

namespace Apps\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use Apps\models\Usuario;
use Apps\models\validar;

class UsuarioController{

    public function getAll(Request $request, Response $response, $args) {

        
        $respuesta = Usuario::get();
        
        $response->getBody()->write(json_encode($respuesta));
        return $response;
    }

    public function getOne(Request $request, Response $response, $args) {

        
        $respuesta = Usuario::where('id',$args['id'])->get();
        
        $response->getBody()->write(json_encode($respuesta));
        return $response;
    }

    public function addOne(Request $request, Response $response, $args) {

        
        $usuario = new Usuario;

        $usuario->nombre = $_POST['nombre'] ?? '';
        $usuario->apellido = $_POST['apellido'] ?? '';
        $usuario->email = $_POST['email'] ?? '';
        $usuario->clave = $_POST['clave'] ?? '';
        $usuario->tipo = $_POST['tipo'] ?? '';
        $respuesta =$usuario->save();

        $response->getBody()->write(json_encode($respuesta));
        return $response;
    }

    public function updateOne(Request $request, Response $response, $args) {

         $usuarioObj = Usuario::where('id',$args['id'])->first();
       
      
        if($usuarioObj->tipo == "alumno"){
            $email = $_POST['email'] ?? '';

            $usuario = Usuario::find($usuarioObj->id);
            $usuario->email = $email;
            $respuesta =$usuario->update();
        $response->getBody()->write(json_encode($respuesta));
        return $response;
         }
        
        
    }

    public function deleteOne(Request $request, Response $response, $args) {

        $usuarioObj = Usuario::where('legajo',$args['legajo'])->first();
       
      
        
        $usuario = Usuario::find($usuarioObj->id);

        $respuesta =$usuario->delete();
    
        $response->getBody()->write(json_encode($respuesta));
        return $response;
    }

    
}