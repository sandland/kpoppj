<?php
declare(strict_types=1);

use App\Controllers\Girls;
use App\Controllers\GirlsIndex;
use App\Middleware\AddJsonResponseHeader;
use App\Middleware\GetGirls;

use DI\ContainerBuilder;
use Slim\Factory\AppFactory;
use Slim\Handlers\Strategies\RequestResponseArgs;
use Slim\Routing\RouteCollectorProxy;

require __DIR__ . '/../vendor/autoload.php';

$builder = new ContainerBuilder();
$container = $builder->addDefinitions(__DIR__ . '/../config/definitions.php')->build();
AppFactory::setContainer($container);
$app = AppFactory::create();

$collector = $app->getRouteCollector();
$collector->setDefaultInvocationStrategy(new RequestResponseArgs());


$app->addBodyParsingMiddleware();


$error_middleware = $app->addErrorMiddleware(true, true, true);
$error_handler = $error_middleware->getDefaultErrorHandler();
$error_handler->forceContentType('application/json');

$app->add(new AddJsonResponseHeader);

$app->group('/api', function (RouteCollectorProxy $group){
    
    $group->get('/girls', GirlsIndex::class);
    $group->post('/girls', [Girls::class, 'create']);

    $group->group('', function (RouteCollectorProxy $group){
        $group->get('/girls/{id:[0-9]+}', Girls::class . ':show');
    
        $group->patch('/girls/{id:[0-9]+}', Girls::class . ':update');
        
        $group->delete('/girls/{id:[0-9]+}', Girls::class . ':delete');
    })->add(GetGirls::class);

});



$app->run();


