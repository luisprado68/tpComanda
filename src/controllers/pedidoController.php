<?php

namespace Apps\Controllers;

use Apps\models\Bebida;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Illuminate\Support\Facades\DB;
use Apps\models\Pedido;
use Apps\models\Cliente;
use Apps\models\Comida;
use Apps\models\EstadosPedido;
use Apps\models\Mesa;
use Apps\models\Postre;
use Apps\models\Ingreso;
use Apps\models\Operacion;


use Apps\models\Usuario;
use Apps\models\validar;
use Exception;
use Illuminate\Database\Console\Migrations\InstallCommand;

class PedidoController{

    public function getOne(Request $request, Response $response, $args) {

            // $pedido = Pedido::where('id_cliente',1)->first();
            $pedidos = Pedido::where('id_cliente',$args['id_cliente'])->get();
            $cliente="";
            $bebida="";
            $comida="";
            $postre="";
            $estado="";
            $mesa="";
            $importe =0;
            $tiempoComida =0;
            foreach ($pedidos as $pedido) {

                $cliente = Cliente::where('id',$pedido->id_cliente)->value('nombre');
                $bebida .= Bebida::where('id',$pedido->id_bebida)->value('marca')."(".$pedido->cantidad_bebida.") - ";
                $comida .= Comida::where('id',$pedido->id_comida)->value('nombre')."(".$pedido->cantidad_comida.") - ";
                $postre .= Postre::where('id',$pedido->id_postre)->value('nombre')."(".$pedido->cantidad_postre.") - ";
                $estado = EstadosPedido::where('id',$pedido->id_estado)->value('nombre');
                $mesa = Mesa::where('id',$pedido->id_mesa)->value('id');
                $tiempoComida =  $tiempoComida + $pedido->tiempo;
                $importe = $importe + $pedido->importe;
                //calcular importe
               
            }
           
           
            echo "Pedido:\n";
            echo "Cliente: ".$cliente."\n";
            echo"Bebidas: ".$bebida."\n";
            echo "Comidas: ".$comida."\n";
            echo "Postre: ".$postre."\n";
            echo "Estado: ".$estado."\n";
            echo "Mesa: ".$mesa."\n";
            echo "Importe total: ".$importe."\n";
            echo "Tiempo: ".$tiempoComida."\n";

            
                $response->getBody()->write(json_encode($pedido));
                return $response;       
     }

    public function getAll(Request $request, Response $response, $args) {

        
        $pedidosTodos = Pedido::get();
        $id_pedido_clientes = array();
        $id_anterior=0;
        foreach ($pedidosTodos as  $value) {

            if($id_anterior != $value->id_cliente){

                array_push($id_pedido_clientes, $value->id_cliente);
                $id_anterior = $value->id_cliente;
            }
        }

        foreach ($id_pedido_clientes as $value) {
            
            

                $pedidos = Pedido::where('id_cliente',$value)->get();
                $cliente="";
                $bebida="";
                $comida="";
                $postre="";
                $estado="";
                $mesa="";
                $importe =0;
                $tiempoComida =0;

                foreach ($pedidos as $pedido) {

                    $cliente = Cliente::where('id',$pedido->id_cliente)->value('nombre');
                    $bebida .= Bebida::where('id',$pedido->id_bebida)->value('marca')."(".$pedido->cantidad_bebida.") - ";
                    $comida .= Comida::where('id',$pedido->id_comida)->value('nombre')."(".$pedido->cantidad_comida.") - ";
                    $postre .= Postre::where('id',$pedido->id_postre)->value('nombre')."(".$pedido->cantidad_postre.") - ";
                    $estado = EstadosPedido::where('id',$pedido->id_estado)->value('nombre');
                    $mesa = Mesa::where('id',$pedido->id_mesa)->value('id');
                    $tiempoComida =  $tiempoComida + $pedido->tiempo;
                    $importe = $importe + $pedido->importe;
                    //calcular importe
                
                }

                echo "----------------------------------Pedido-----------------:\n";
                echo "Cliente: ".$cliente."\n";
                echo"Bebidas: ".$bebida."\n";
                echo "Comidas: ".$comida."\n";
                echo "Postre: ".$postre."\n";
                echo "Estado: ".$estado."\n";
                echo "Mesa: ".$mesa."\n";
                echo "Importe total: ".$importe."\n";
                echo "Tiempo: ".$tiempoComida."\n";


        }

       
        
        $response->getBody()->write(json_encode("---------------------------------"));
        return $response;
    }

    public function getMasVendido(Request $request, Response $response, $args) {

        
        $precioMaximo = Pedido::max('importe');
        $pedidos = Pedido::where('importe',$precioMaximo)->get();

        foreach ($pedidos as $value) {
            
            echo Comida::where('id',$value->id_comida)->value('nombre');
            break;
        }
        
        $response->getBody()->write(json_encode($pedidos));
        return $response;
    }

    public function getMenosVendido(Request $request, Response $response, $args) {

        
        $precioMinimo = Pedido::min('importe');
        $pedidos = Pedido::where('importe',$precioMinimo)->get();

        foreach ($pedidos as $value) {
            
            echo Comida::where('id',$value->id_comida)->value('nombre');
            break;
        }
        
        $response->getBody()->write(json_encode($pedidos));
        return $response;
    }
    
    public function cancelados(Request $request, Response $response, $args) {

        
        
        $pedidos = Pedido::where('id_estado',5)->get();

        // foreach ($pedidos as $value) {
        //     $value->id_comida;
        //     echo Comida::where('id',$value->id_comida)->value('nombre');
        //     break;
        // }
        
        $response->getBody()->write(json_encode($pedidos));
        return $response;
    }

    public function masUsada(Request $request, Response $response, $args) {

        // $pedidos = Pedido::all()->groupBy('id_mesa');
        $numero=0;
        $id=0;
        $mesas = Mesa::all();
        foreach ($mesas as $value) {
            $cantidad = Pedido::where("id_mesa",$value->id)->count();
            if($cantidad > $numero){
                $numero = $cantidad;
                $id = $value->id;
            }
        }
        $resultado = "id Mesa:". $id." :Cantidad ".$numero;
        $response->getBody()->write(json_encode($resultado));
        return $response;
    }
    
    public function menosUsada(Request $request, Response $response, $args) {

        // $pedidos = Pedido::all()->groupBy('id_mesa');
        $numero=0;
        $id=0;
        $flag=0;
        $mesas = Mesa::all();
        foreach ($mesas as $value) {
            $cantidad = Pedido::where("id_mesa",$value->id)->count();
            if($cantidad !=0){
                if($cantidad < $numero || $flag == 0){
                    $numero = $cantidad;
                    $id = $value->id;
                    $flag=1;
                }
            }
           
        }
        $resultado = "id Mesa:". $id." :Cantidad ".$numero;
        $response->getBody()->write(json_encode($resultado));
        return $response;
    }

    public function getMayorImporte(Request $request, Response $response, $args) {

        
        $precioMaximo = Pedido::max('importe');
        $pedidos = Pedido::where('importe',$precioMaximo)->get();

        foreach ($pedidos as $value) {
           
            $mesaMayor = Mesa::where('id',$value->id_mesa)->value('id');
            break;
        }
        
        $response->getBody()->write(json_encode("Mesa: ".$mesaMayor));
        return $response;
    }

    public function getMenorImporte(Request $request, Response $response, $args) {

        
        $precioMinimo = Pedido::min('importe');
        $pedidos = Pedido::where('importe',$precioMinimo)->get();

        foreach ($pedidos as $value) {
         
            $mesaMayor = Mesa::where('id',$value->id_mesa)->value('id');
            break;
        }
        
        $response->getBody()->write(json_encode("Mesa: ".$mesaMayor));
        return $response;
    }

    public function addOne(Request $request, Response $response, $args) {
      

        $id_cliente = $_POST['id_cliente'] ?? '';
        $id_bebida = $_POST['id_bebida'] ?? '';
        $id_comida = $_POST['id_comida'] ?? '';
        $id_postre = $_POST['id_postre'] ?? '';
        $cantidad_bebida= $_POST['cantidad_bebida'] ?? '';
        $cantidad_postre = $_POST['cantidad_postre'] ?? '';
        $cantidad_comida= $_POST['cantidad_comida'] ?? '';
        $id_mesa = $_POST['id_mesa'] ?? '';
        $continuaPidiendo=$_POST['continua'] ?? 'no';
        

        $pedidoNuevo = new Pedido;
        try {

            $pedidos = Pedido::get();
            $mesa = Mesa::where('id',$id_mesa)->firstOrFail();

            foreach ($pedidos as  $pedido) {
                if($pedido->id_mesa == $id_mesa && $pedido->id_cliente != $id_cliente && $mesa->id_estado != 4){
                    throw  new Exception("Mesa Ocupada");
                }
                if($pedido->id_mesa == $id_mesa && $pedido->id_cliente == $id_cliente && $mesa->id_estado == 1){
                    throw  new Exception("Mesa Ocupada");
                }
            }
            
            
            
            $cliente = Cliente::where('id',$id_cliente)->firstOrFail();
            $bebida = Bebida::where('id',$id_bebida)->firstOrFail();
            $comida = Comida::where('id',$id_comida)->firstOrFail();
            $postre = Postre::where('id',$id_postre)->firstOrFail();
            

            // if($alumno->tipo == "alumno"){

                

                $importeBebida=0;
                $importeComida=0;
                $importePostre=0;
                $tiempoComida=0;
                $codigo=0;
                $importeBebida = $importeBebida  + Bebida::where('id',$id_bebida)->value('precio') * $cantidad_bebida;
                $importeComida = $importeComida  + Comida::where('id',$id_comida)->value('precio') * $cantidad_comida;
                $importePostre = $importePostre  + Postre::where('id',$id_postre)->value('precio') * $cantidad_postre;
                $tiempoComida = $tiempoComida +  Comida::where('id',$id_comida)->value('tiempo')* $cantidad_comida;
                $importe = $importeBebida + $importeComida + $importePostre;

                $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                // Output: iNCHNGzByPjhApvn7XBD

                $pedidosHechos = Pedido::where('id_cliente',$cliente->id)->get();
               
                    foreach ($pedidosHechos as  $value) {
                        $codigo = $value->codigo;
                         break;
                    }
                
                if($codigo == 0){
                   
                   $codigo = generate_string($permitted_chars,5);
                }
                

                $pedidoNuevo->id_cliente =$cliente->id;
                $pedidoNuevo->id_bebida = $bebida->id;
                $pedidoNuevo->cantidad_bebida = $cantidad_bebida;
                $pedidoNuevo->id_comida = $comida->id;
                $pedidoNuevo->cantidad_comida = $cantidad_comida;
                $pedidoNuevo->id_postre = $postre->id;
                $pedidoNuevo->cantidad_postre = $cantidad_postre;
                $pedidoNuevo->id_mesa = $mesa->id;

                
                //actualizo mesa
                if($continuaPidiendo == "si"){
                    $mesaOcuoada= Mesa::find($mesa->id);
                    $mesaOcuoada->id_estado = 4;
                    $mesaOcuoada->save();  
                }
                else{

                    $mesaOcuoada= Mesa::find($mesa->id);
                    $mesaOcuoada->id_estado = 1;
                    $mesaOcuoada->save();
                }
                

                $clienteCodigo= Cliente::find($cliente->id);
                $clienteCodigo->codigo = $codigo;
                $clienteCodigo->save();

                $pedidoNuevo->id_estado = 1;
                $pedidoNuevo->importe = $importe;
                $pedidoNuevo->tiempo = $tiempoComida;
                $pedidoNuevo->codigo = $codigo;
                $respuesta =$pedidoNuevo->save();

                $response->getBody()->write(json_encode($respuesta));
            
            // }else{
            //     throw  new Exception;
            // }


            
            
        } 
        catch (\Throwable $th) {
            echo $th->getMessage();
            echo "\nCliente o comida o bebida o postre inexistente";
        }
        
        return $response;
        
    }

    public function updateOne(Request $request, Response $response, $args) {

        //valida cocinero y mozo para entregar
        $id_estado = $_POST['id_estado'] ?? '';
        
        $cantidad =0;
        $operaciones = new Operacion;
        
        try {
            
            $pedidosHechos = Pedido::where('id_cliente',$args['id_cliente'])->get();

            Pedido::where('id_cliente',$args['id_cliente'])->firstOrFail();

            foreach ($pedidosHechos as  $pedido) {
             
            
                $token = $_SERVER['HTTP_TOKEN'] ?? '';
                $decoded= Validar::validarJWT($token);
   
                if($decoded != null){
                   $id_usuario = Validar::obtenerIdUsuario($decoded);
                }
                
                              
                   if($pedido->id_estado != $id_estado){
                       
                       if($id_estado == 4){
                           $mesaOcupada= Mesa::find($pedido->id_mesa);
                           $mesaOcupada->id_estado = 2;
                           $mesaOcupada->save();
                       }
                       

                       $pedido->id_estado = $id_estado;
                       $estado = EstadosPedido::where('id',$id_estado)->value('nombre');
   
                       $operaciones->id_usuario=$id_usuario;
                       $operaciones->operacion=$estado;
                       $cantidad = $pedido->cantidad_comida + $cantidad;
                       $operaciones->cantidad = $cantidad;
                       $operaciones->save();
                       $respuesta = $pedido->save();
                   }
                   else{
                        throw new Exception("El estado no es distinto");
                   }
                           
   
           }

        } catch (\Throwable $th) {
            
            echo "Cliente no disponible o algunos de los id no estan disponibles.";
        }
        
               
        
        
        $response->getBody()->write(json_encode($respuesta));
        return $response;
    }

    public function deleteOne(Request $request, Response $response, $args) {

        
        $alumno = Pedido::find(5);

        // $alumno->nombre = "Maria Jimena";
        // $alumno->apellido = "Lopez";
        // $alumno->id_localidad = 2;
        $respuesta =$alumno->delete();
    
        $response->getBody()->write(json_encode($respuesta));
        return $response;
    }

   
}

 

 
function generate_string($input, $strength = 16) {
    $input_length = strlen($input);
    $random_string = '';
    for($i = 0; $i < $strength; $i++) {
        $random_character = $input[mt_rand(0, $input_length - 1)];
        $random_string .= $random_character;
    }
 
    return $random_string;
}
 
