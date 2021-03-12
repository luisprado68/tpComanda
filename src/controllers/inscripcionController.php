<?php

namespace Apps\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use Apps\models\Inscripcion;
use Apps\models\Materia;
use Apps\models\Usuario;
use Apps\models\validar;
use Exception;
use Illuminate\Database\Console\Migrations\InstallCommand;

class InscripcionController{

    public function getAll(Request $request, Response $response, $args) {

        
    //     $notas = array();
    //     $rta = Materia::where('id','=',$args['idMateria'])->get();
    //     foreach ($rta as $key => $value) {
    //         $nota = Inscripcion::where('idMateria','=',$value['id'])->get()->first();
    //         array_push($notas,$nota);
    //     }
    //     $response->getBody()->write(json_encode($notas));
    //     return $response;
    // }

    // public function getOne(Request $request, Response $response, $args) {

        
        $respuesta = Inscripcion::where('id',$args['id'])->get();
        
        $response->getBody()->write(json_encode($respuesta));
        return $response;
    }

    public function addOne(Request $request, Response $response, $args) {

        
        
        $inscripcion = new Inscripcion;
        try {
          
            $materia = Materia::where('id',$args['id'])->firstOrFail();
            $id = $_POST['id_alumno'] ?? '';
            $alumno = Usuario::where('id',$id)->firstOrFail();

            if($alumno->tipo == "alumno"){

                $inscripcion->id_materia =$materia->id;
                $inscripcion->id_alumno = $alumno->id;
            
                $respuesta =$inscripcion->save();

                $response->getBody()->write(json_encode($respuesta));
            
            }else{
                throw  new Exception;
            }


            
            
        } 
        catch (\Throwable $th) {
            echo "La materia o Alumno no existe o no tiene permiso.";
        }
        
        return $response;
        
    }

    public function updateOne(Request $request, Response $response, $args) {

        
        $nota = Inscripcion::where('id_materia',$args['id']);
    //     $body = $request->getParsedBody();
    //   $algo = $body['nota'];
    //  $nota->nota = $_POST['nota'];
    //     // $alumno->apellido = "Lopez";
    //     // $alumno->id_localidad = 2;
        $respuesta =$nota->save();
    
        $response->getBody()->write(json_encode($respuesta));
        return $response;
    }

    public function deleteOne(Request $request, Response $response, $args) {

        
        $alumno = Inscripcion::find(5);

        // $alumno->nombre = "Maria Jimena";
        // $alumno->apellido = "Lopez";
        // $alumno->id_localidad = 2;
        $respuesta =$alumno->delete();
    
        $response->getBody()->write(json_encode($respuesta));
        return $response;
    }

   
}