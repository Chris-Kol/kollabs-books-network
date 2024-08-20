<?php

declare(strict_types=1);

namespace KollabsBooks\BookCatalog\Domain\Repository;

use KollabsBooks\BookCatalog\Domain\Entity\Book;
use KollabsBooks\BookCatalog\Domain\ValueObject\Uuid;

interface BookRepositoryInterface
{
    public function findById(Uuid $id): ?Book;
    public function save(Book $book): void;
    public function findAll(): array;
}