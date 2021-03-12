<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel=" icon" href="./img/chef.ico" type="image/x-icon">
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <nav>
        <div class="contenedor">
        <a href="index.php"><img src="./img/chef.png" alt=""></a>
        </div>
    
    <div class="contenedor-dos">
    <h1>API REST - Restaurante "La Comanda"</h1>
    </div>
    </nav>
    <div class="datos">
        <?php
        use Psr\Http\Message\ResponseInterface as Response;
        use Psr\Http\Message\ServerRequestInterface as Request;
        use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
        use Slim\Factory\AppFactory;
        use Slim\Routing\RouteCollectorProxy;
        use Config\Database;
        
        use Apps\Controllers\UsuarioController;
        use Apps\Controllers\BebidaController;
        use Apps\Controllers\ClienteController;
        use Apps\Controllers\ComidaController;
        use Apps\Controllers\EncuestaController;
        use Apps\Controllers\PostreController;
        use Apps\Controllers\MesaController;
        use Apps\Controllers\EstadosPedidoController;
        use Apps\Controllers\IngresoController;
        use Apps\Controllers\PedidoController;
        use Apps\Controllers\MateriaController;
        use Apps\Controllers\InscripcionController;
        use Apps\Controllers\OperacionController;
        use Apps\Middlewares\JsonMiddleware;
        use Apps\Middlewares\AuthMiddleware;
        
        
        require __DIR__ . '/vendor/autoload.php';
        
        $app = AppFactory::create();
        $app->setBasePath('');
        new Database;
        
        $app->group('/',function(RouteCollectorProxy $group){

    
        $group->get('clientes[/]',ClienteController::class.":getAll");
        $group->get('bebidas[/]',BebidaController::class.":getAll");
        $group->post('bebidas[/]',BebidaController::class.":addOne");
        $group->get('comidas[/]',ComidaController::class.":getAll");
        $group->post('comidas[/]',ComidaController::class.":addOne");
        $group->get('postres[/]',PostreController::class.":getAll");
        $group->post('postres[/]',PostreController::class.":addOne");
        $group->get('mesas[/]',MesaController::class.":getAll");
        $group->post('mesas/{id}[/]',MesaController::class.":updateOne");
        $group->get('estados[/]',EstadosPedidoController::class.":getAll");
        $group->get('pedidos/{id_cliente}[/]',PedidoController::class.":getOne");
        $group->get('pedidos[/]',PedidoController::class.":getAll");
        $group->get('masVendido[/]',PedidoController::class.":getMasVendido");
        $group->get('menosVendido[/]',PedidoController::class.":getMenosVendido");
        $group->get('mesaMasUsada[/]',PedidoController::class.":masUsada");
        $group->get('mesaMenosUsada[/]',PedidoController::class.":menosUsada");
        $group->get('mesaMayorImporte[/]',PedidoController::class.":getMayorImporte");
        $group->get('mesaMenorImporte[/]',PedidoController::class.":getMenorImporte");


        $group->post('clientes[/]',ClienteController::class.":addOne");
        $group->post('pedidos[/]',PedidoController::class.":addOne");
        $group->get('cancelados[/]',PedidoController::class.":cancelados");
        $group->get('usuarios[/]',UsuarioController::class.":getAll");
        $group->post('usuarios[/]',UsuarioController::class.":addOne");
        $group->get('ingreso[/]',IngresoController::class.":getAll");
        $group->post('ingreso[/]',IngresoController::class.":addOne");
        $group->post('realizarPedido/{id_cliente}[/]',PedidoController::class.":updateOne")->add(new AuthMiddleware("todos"));
        $group->get('operaciones/{id_usuario}[/]',OperacionController::class.":getOne");
        $group->get('operaciones[/]',OperacionController::class.":getAll");
        $group->get('encuestas[/]',EncuestaController::class.":getAll");
        $group->get('mejor[/]',EncuestaController::class.":getMejorComentario");
        $group->post('encuestas[/]',EncuestaController::class.":addOne");
    
        })->add(new JsonMiddleware);



        $app->run();
?>
    </div>
    <footer>
      <div class="container center"><a href="https://luisprado.000webhostapp.com/" target="_blank">© Copyright 2021 - Luis Prado Desarrollador Web</a>
    </div>
  </footer>
    
</body>
</html>

