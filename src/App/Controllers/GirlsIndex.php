<?php
declare(strict_types=1);
namespace App\Controllers;

use App\Repositories\GirlsRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class GirlsIndex
{
    
    public function __construct(private readonly GirlsRepository $repository)
    {
    }

    public function __invoke(Request $request, Response $response): Response
    {
        //$repo = $this->get(GirlsRepository::class);
    
        $body = json_encode($this->repository->getAll());
        
        $response->getBody()->write($body);
        
        return $response;
    }
}