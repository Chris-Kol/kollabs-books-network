<?php

declare(strict_types=1);

namespace KollabsBooks\BookCatalog\Infrastructure\Container;

use KollabsBooks\BookCatalog\Application\Service\BookService;
use KollabsBooks\BookCatalog\Application\Service\BookServiceInterface;
use KollabsBooks\BookCatalog\Domain\Repository\BookRepositoryInterface;
use KollabsBooks\BookCatalog\Infrastructure\Persistence\SqlBookRepository;
use KollabsBooks\Shared\Infrastructure\Container\DomainContainerInterface;
use KollabsBooks\Shared\Infrastructure\Persistence\DatabaseInterface;

use function DI\autowire;
use function DI\create;
use function DI\get;

class BookCatalogContainer implements DomainContainerInterface
{
    public static function getDefinitions(): array
    {
        return [
            BookRepositoryInterface::class => create(SqlBookRepository::class)->constructor(
                get(DatabaseInterface::class),
                get('queryFactory')
            ),
            BookServiceInterface::class => autowire(BookService::class),
        ];
    }
}