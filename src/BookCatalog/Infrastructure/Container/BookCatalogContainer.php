<?php

declare(strict_types=1);

namespace KollabsBooks\BookCatalog\Infrastructure\Container;

use KollabsBooks\BookCatalog\Application\Service\BookService;
use KollabsBooks\BookCatalog\Application\Service\BookServiceInterface;
use KollabsBooks\BookCatalog\Domain\Repository\BookRepositoryInterface;
use KollabsBooks\BookCatalog\Infrastructure\Persistence\SqlBookRepository;
use KollabsBooks\Shared\Infrastructure\Container\DomainContainerInterface;

class BookCatalogContainer implements DomainContainerInterface
{
    public static function getDefinitions(): array
    {
        return [
            BookRepositoryInterface::class => \DI\get(SqlBookRepository::class),
            BookServiceInterface::class => \DI\get(BookService::class),
        ];
    }
}