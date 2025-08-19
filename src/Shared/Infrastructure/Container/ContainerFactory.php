<?php

declare(strict_types=1);

namespace KollabsBooks\Shared\Infrastructure\Container;

use DI\Container;
use DI\ContainerBuilder;
use KollabsBooks\BookCatalog\Infrastructure\Container\BookCatalogContainer;
use KollabsBooks\Shared\Infrastructure\Config\DatabaseConfig;
use Pixie\Connection;
use Pixie\QueryBuilder\QueryBuilderHandler;

class ContainerFactory
{
    /**
     * @throws \Exception
     */
    public static function create(): Container
    {
        $containerBuilder = new ContainerBuilder();

        $containerBuilder->addDefinitions([
            'pixieQueryBuilder' => function () {
                $config = DatabaseConfig::getConfig();
                $connection = new Connection('mysql', [
                    'host' => $config['host'],
                    'database' => $config['database'],
                    'username' => $config['username'],
                    'password' => $config['password'],
                ]);
                return new QueryBuilderHandler($connection);
            },
        ]);

        // Domain-specific definitions
        $containerBuilder->addDefinitions(BookCatalogContainer::getDefinitions());

        return $containerBuilder->build();
    }
}