<?php

declare(strict_types=1);

namespace KollabsBooks\BookCatalog\Domain\Repository;

use InvalidArgumentException;
use KollabsBooks\BookCatalog\Domain\Entity\Book;
use KollabsBooks\BookCatalog\Domain\ValueObject\Collection\BookCollection;
use KollabsBooks\BookCatalog\Domain\ValueObject\Uuid;

interface BookRepositoryInterface
{
    /**
     * @throws InvalidArgumentException
     */
    public function findBookById(Uuid $id): ?Book;

    public function store(Book $book): void;
    public function add(Book $book): void;
    public function findAll(): BookCollection;
    public function remove(Uuid $id): bool;
}