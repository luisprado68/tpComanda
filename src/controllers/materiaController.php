<?php

namespace Apps\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use Apps\models\Materia;
use Apps\models\validar;

class MateriaController{

    public function getAll(Request $request, Response $response, $args) {

        
        $respuesta = Materia::get();
        
        $response->getBody()->write(json_encode($respuesta));
        return $response;
    }

    public function getOne(Request $request, Response $response, $args) {

        
        $respuesta = Materia::where('id',$args['id'])->get();
        
        $response->getBody()->write(json_encode($respuesta));
        return $response;
    }

    public function addOne(Request $request, Response $response, $args) {

        
        $materia = new Materia;

        
        $materia->nombre = $_POST['materia'] ?? '';
        $materia->cuatrimestre = $_POST['cuatrimestre'] ?? '';
        $materia->cupos = $_POST['cupos'] ?? '';
        $respuesta =$materia->save();

        $response->getBody()->write(json_encode($respuesta));
        return $response;
    }

    public function updateOne(Request $request, Response $response, $args) {

        
        $alumno = Materia::find(2);

        $alumno->nombre = "Maria Jimena";
        // $alumno->apellido = "Lopez";
        // $alumno->id_localidad = 2;
        $respuesta =$alumno->save();
    
        $response->getBody()->write(json_encode($respuesta));
        return $response;
    }

    public function deleteOne(Request $request, Response $response, $args) {

        
        $alumno = Materia::find(5);

        // $alumno->nombre = "Maria Jimena";
        // $alumno->apellido = "Lopez";
        // $alumno->id_localidad = 2;
        $respuesta =$alumno->delete();
    
        $response->getBody()->write(json_encode($respuesta));
        return $response;
    }

   
}