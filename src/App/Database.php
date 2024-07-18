<?php
declare(strict_types=1);

namespace App;

use PDO;

class Database {
    

    public function __construct(
        private readonly string $host,
        private readonly string $databaseName,
        private readonly string $username,
        private readonly string $password)
    {
    }

    public function getConnection(): PDO{
        $dsn = "mysql:host=$this->host;dbname=$this->databaseName;charset=utf8";
        return new PDO($dsn, $this->username, $this->password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    }
}