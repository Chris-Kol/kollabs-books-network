<?php

declare(strict_types=1);

namespace KollabsBooks\Shared\Infrastructure\Config;

class DatabaseConfig
{
    public static function getConfig(): array
    {
        return [
            'host' => 'mysql',
            'database' => 'kollabs_books',
            'username' => 'user',
            'password' => 'password',
            'charset' => 'utf8mb4',
            'dsn' => "mysql:host=mysql;dbname=kollabs_books;charset=utf8mb4",
        ];
    }
}