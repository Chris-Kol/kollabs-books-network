<?php

declare(strict_types=1);

namespace KollabsBooks\BookCatalog\Domain\ValueObject\Collection;

use InvalidArgumentException;
use KollabsBooks\BookCatalog\Domain\Entity\Book;

final class BookCollection
{
    private array $books;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(array $books)
    {
        foreach ($books as $book) {
            if (!$book instanceof Book) {
                throw new InvalidArgumentException('All items must be instances of Book');
            }
        }
        $this->books = $books;
    }

    public function toArray(): array
    {
        return array_map(fn (Book $book) =>
            [
                'id' => $book->getId()->getValue(),
                'title' => $book->getTitle()->getValue(),
                'author' => $book->getAuthor()->getName(),
                'price' => [
                    'amount' => $book->getPrice()->getAmount(),
                    'currency' => $book->getPrice()->getCurrency()
                ],
                'stock' => $book->getStock()->getValue(),
            ], $this->books
        );
    }
}