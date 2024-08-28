<?php

declare(strict_types=1);

namespace KollabsBooks\BookCatalog\Domain\ValueObject\Collection;

use Bag\Collection;
use InvalidArgumentException;
use KollabsBooks\BookCatalog\Domain\Entity\Book;

final class BookCollection extends Collection
{
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
        parent::__construct($books);
    }

    public function toArray(): array
    {
        return array_map(fn (Book $book) =>
            [
                'id' => $book->getId()->getValue(),
                'title' => $book->getTitle()->getValue(),
                'author' => $book->getAuthor()->getName(),
                'price' => [
                    'amount' => $book->getPrice()->getAmountAsFloat(),
                    'currency' => $book->getPrice()->getCurrency()
                ],
                'stock' => $book->getStock()->getValue(),
            ], $this->items
        );
    }
}