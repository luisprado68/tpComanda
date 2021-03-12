<?php

namespace Apps\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use Apps\models\Operacion;
use Apps\models\validar;

class OperacionController{

    public function getAll(Request $request, Response $response, $args) {

        
        $respuesta = Operacion::get();
        
        $response->getBody()->write(json_encode($respuesta));
        return $response;
    }

    public function getOne(Request $request, Response $response, $args) {

        // try {
        //     //code...
        // } catch (\Throwable $th) {
        //     //throw $th;
        // }

         try {

            $respuesta = Operacion::where('id_usuario',$args['id_usuario'])->firstOrFail();
            $response->getBody()->write(json_encode($respuesta));
        } catch (\Throwable $th) {
            echo "No se encuentra el usuario";
        }
        

        
        
       
        return $response;
    }

    // public function addOne(Request $request, Response $response, $args) {

        
    //     $bebida = new Operacion;

    //     $bebida->marca = $_POST['marca'] ?? '';
    //     $bebida->tipo = $_POST['tipo'] ?? '';
    //     $bebida->precio = $_POST['precio'] ?? '';
      
    //     $respuesta =$bebida->save();

    //     $response->getBody()->write(json_encode($respuesta));
    //     return $response;
    // }

    // public function updateOne(Request $request, Response $response, $args) {

    //      $usuarioObj = Operacion::where('legajo',$args['legajo'])->first();
       
      
    //     if($usuarioObj->tipo == "alumno"){
    //         $email = $_POST['email'] ?? '';

    //         $usuario = Operacion::find($usuarioObj->id);
    //         $usuario->email = $email;
    //         $respuesta =$usuario->update();
    //     $response->getBody()->write(json_encode($respuesta));
    //     return $response;
    //      }
        
        
    // }

    public function deleteOne(Request $request, Response $response, $args) {

        $usuarioObj = Operacion::where('legajo',$args['legajo'])->first();
       
      
        
        $usuario = Operacion::find($usuarioObj->id);

        $respuesta =$usuario->delete();
    
        $response->getBody()->write(json_encode($respuesta));
        return $response;
    }

    
}