<?php
declare(strict_types=1);
namespace App\Repositories;

use App\Database;
use PDO;

class GirlsRepository
{
    public function __construct(private readonly Database $database)
    {

    }

public function getAll(): array
    {
        $stmt = $this->database->getConnection()->query('SELECT * FROM girls');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


public function getById(int $id): array|bool
    {
        $sql = 'SELECT * FROM girls WHERE id = :id';
        $pdo = $this->database->getConnection();
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    
    }
    
public function create(array $data): string
    {
        
   
        
        $sql = 'INSERT INTO girls (id, name, birth, display, brand_id) VALUES (null, :name, :birth, :display, :brandId)';
        $pdo = $this->database->getConnection();
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindValue(':name', $data['name'], PDO::PARAM_STR);
        $stmt->bindValue(':birth', $data['birth'], PDO::PARAM_STR);
        
        if (empty($data['display'])){
            $stmt->bindValue(':display', '', PDO::PARAM_STR);
        }else {
            $stmt->bindValue(':display', $data['display'], PDO::PARAM_STR);   
        }
        
  
        $stmt->bindValue(':brandId', $data['brandId'], PDO::PARAM_INT);

        $stmt->execute();

        return $pdo->lastInsertId();
    }
    
    
public function update(int $id, array $data): int
    {
        
        $sql = 'UPDATE girls SET name = :name, birth = :birth, display = :display, brand_id = :brandId WHERE id = :id';
        
        $pdo = $this->database->getConnection();
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindValue(':name', $data['name'], PDO::PARAM_STR);
        $stmt->bindValue(':birth', $data['birth'], PDO::PARAM_STR);
        
        if (empty($data['display'])){
            $stmt->bindValue(':display', '', PDO::PARAM_STR);
        }else {
            $stmt->bindValue(':display', $data['display'], PDO::PARAM_STR);   
        }
        
  
        $stmt->bindValue(':brandId', $data['brandId'], PDO::PARAM_INT);

        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->rowCount();
    }
    
    public function delete(string $id): int{
        $sql = 'DELETE FROM girls WHERE id = :id';
        $pdo = $this->database->getConnection();
        
        $stml = $pdo->prepare($sql);

        $stml->bindValue(':id', $id, PDO::PARAM_INT);

        $stml->execute();

        return $stml->rowCount();
    }
}