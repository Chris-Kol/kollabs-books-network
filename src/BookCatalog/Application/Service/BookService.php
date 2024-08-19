<?php

declare(strict_types=1);

namespace KollabsBooks\BookCatalog\Application\Service;

use KollabsBooks\BookCatalog\Domain\Entity\Book;
use KollabsBooks\BookCatalog\Domain\Repository\BookRepositoryInterface;
use KollabsBooks\Shared\Domain\ValueObject\Uuid;
use KollabsBooks\Shared\Domain\ValueObject\Title;
use KollabsBooks\Shared\Domain\ValueObject\Price;

final class BookService implements BookServiceInterface
{
    private BookRepositoryInterface $bookRepository;

    public function __construct(BookRepositoryInterface $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    public function createBook(
        string $id,
        string $title,
        string $author,
        int $priceAmount,
        string $currency,
        int $stock
    ): Book {
        $book = new Book(
            new Uuid($id),
            new Title($title),
            $author,
            new Price($priceAmount, $currency),
            $stock
        );

        $this->bookRepository->save($book);

        return $book;
    }

    public function getBook(string $id): ?Book
    {
        return $this->bookRepository->findById(new Uuid($id));
    }

    public function getAllBooks(): array
    {
        return $this->bookRepository->findAll();
    }
}