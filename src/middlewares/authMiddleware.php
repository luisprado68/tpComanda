<?php
namespace Apps\Middlewares;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;
use Apps\models\validar;


// use Psr\Http\Message\ResponseInterface as Response;

class AuthMiddleware
{
    /**
     * Example middleware invokable class
     *
     * @param  ServerRequest  $request PSR-7 request
     * @param  RequestHandler $handler PSR-15 request handler
     *
     * @return Response
     */

     public $tipo;

     public function __construct($tipo)
     {
         $this->tipo=$tipo;
     }
     
    public function __invoke(Request $request, RequestHandler $handler): Response
    {

        $token = $_SERVER['HTTP_TOKEN'] ?? '';
        $valido = false;

        $decoded= Validar::validarJWT($token);
        if($decoded != null){
           
            if($this->tipo == "todos"){
                
                $valido = true;
            }
            else if(validar::validarTipo($decoded,$this->tipo)){
                $valido = true;
            }
            
        }
                
        

        if (!$valido) {
            $response = new Response();
            $response->getBody()->write("No posee autorización para ingresar");
            // throw new \Slim\Exception\HttpForbiddenException($request);
            return $response->withStatus(403);
        } else {
            $response = $handler->handle($request);
            $existingContent = (string) $response->getBody();
            $resp = new Response();
            $resp->getBody()->write($existingContent);
            return $resp;
        }
    }
}
