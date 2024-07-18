<?php
declare(strict_types=1);
namespace App\Controllers;

use App\Repositories\GirlsRepository;
use http\Message\Body;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class Girls
{
    public function __construct(private readonly GirlsRepository $repository)
    {
    }

    public function show(Request $request, Response $response, string $id): Response
    {
        
        $girls = $request->getAttribute('girls');
        
        $body = json_encode($girls);
        $response->getBody()->write($body); 
        return $response;
    }
    
    public function create(Request $request, Response $response): Response
    {
        $body = $request->getParsedBody();

        $id = $this->repository->create($body);
        
        $body = json_encode([
        'message' => 'Girls created', 'id' => $id
    ]);
        $response->getBody()->write($body);
        
        return $response->withStatus(201);
    }
    
public function update(Request $request, Response $response, string $id): Response
    {
        $body = $request->getParsedBody();

        $rows = $this->repository->update((int)$id, $body);
        
        $body = json_encode([
        'message' => 'Girls updated', 'rows' => $rows
    ]);
        $response->getBody()->write($body);
        
        return $response;
    }
    
    public function delete(Request $request, Response $response, string $id): Response{
        $rows = $this->repository->delete($id);
        $body = json_encode([
            'message' => 'Girl deleted',
            'rows' => $rows
            
    ]);

        $response->getBody()->write($body);
        return $response;
    }
}