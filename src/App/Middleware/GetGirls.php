<?php
declare(strict_types=1);

namespace App\Middleware;

use App\Repositories\GirlsRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as Handler;
use Slim\Exception\HttpNotFoundException;
use Slim\Routing\RouteContext;


class GetGirls
{
    public function __construct(private readonly GirlsRepository $repository)
    {
    }

    public function __invoke(Request $request, Handler $handler): Response
    {
        $context = RouteContext::fromRequest($request);
        $route = $context->getRoute();

        $id = $route->getArgument('id');
        
        //$repository = $this->get(GirlsRepository::class);
        
        $girsl = $this->repository->getById((int) $id);
        
        if ($girsl === false){
            throw new HttpNotFoundException($request, 'Girls not found');
        }


        $request = $request->withAttribute('girls', $girsl);
        
        return $response = $handler->handle($request);
        
    }
}
