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
    public function getBookById(Uuid $id): ?Book;

    public function saveBook(Book $book): void;
    public function getAllBooks(): BookCollection;
}