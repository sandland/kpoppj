<?php
declare(strict_types=1);

use App\Database;

return [
    Database::class => function(){
    return new Database(
        host: 'localhost',
        databaseName: 'kpopdb',
        username: 'root', password: 'IntelliP24.X'
    );
}        
];