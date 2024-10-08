<?php

declare(strict_types=1);

namespace KollabsBooks\Shared\Infrastructure\Container;

use Aura\SqlQuery\QueryFactory;
use DI\Container;
use DI\ContainerBuilder;
use KollabsBooks\BookCatalog\Infrastructure\Container\BookCatalogContainer;
use KollabsBooks\Shared\Infrastructure\Config\DatabaseConfig;
use KollabsBooks\Shared\Infrastructure\Persistence\AuraSql;
use KollabsBooks\Shared\Infrastructure\Persistence\DatabaseInterface;

class ContainerFactory
{
    /**
     * @throws \Exception
     */
    public static function create(): Container
    {
        $containerBuilder = new ContainerBuilder();

        $containerBuilder->addDefinitions([
            DatabaseInterface::class => function () {
                $config = DatabaseConfig::getConfig();
                return new AuraSql(
                    $config['dsn'],
                    $config['username'],
                    $config['password']
                );
            },
            'queryFactory' => new QueryFactory('mysql'),
        ]);

        // Domain-specific definitions
        $containerBuilder->addDefinitions(BookCatalogContainer::getDefinitions());

        return $containerBuilder->build();
    }
}