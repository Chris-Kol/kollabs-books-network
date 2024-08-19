<?php

declare(strict_types=1);

namespace KollabsBooks\BookCatalog\Application\Service;

use KollabsBooks\BookCatalog\Domain\Entity\Book;

interface BookServiceInterface
{
    public function createBook(
        string $id,
        string $title,
        string $author,
        int $priceAmount,
        string $currency,
        int $stock
    ): Book;
    public function getBook(string $id): ?Book;
    public function getAllBooks(): array;
}