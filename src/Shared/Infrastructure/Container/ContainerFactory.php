<?php

declare(strict_types=1);

namespace KollabsBooks\Shared\Infrastructure\Container;

use DI\Container;
use DI\ContainerBuilder;
use KollabsBooks\BookCatalog\Application\Service\BookService;
use KollabsBooks\BookCatalog\Infrastructure\Container\BookCatalogContainer;
use KollabsBooks\BookCatalog\Infrastructure\Persistence\SqlBookRepository;
use KollabsBooks\Shared\Infrastructure\Config\DatabaseConfig;
use KollabsBooks\Shared\Infrastructure\Persistence\AuraSql;
use KollabsBooks\Shared\Infrastructure\Persistence\DatabaseInterface;

class ContainerFactory
{
    public static function create(): Container
    {
        $containerBuilder = new ContainerBuilder();

        $containerBuilder->addDefinitions([
            DatabaseInterface::class => function() {
                $config = DatabaseConfig::getConfig();
                return new AuraSql(
                    $config['dsn'],
                    $config['username'],
                    $config['password']
                );
            },
        ]);

        // Domain-specific definitions
        $containerBuilder->addDefinitions(BookCatalogContainer::getDefinitions());

        return $containerBuilder->build();
    }
}