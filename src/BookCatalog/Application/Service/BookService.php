<?php

declare(strict_types=1);

namespace KollabsBooks\BookCatalog\Application\Service;

use Brick\Math\Exception\NumberFormatException;
use Brick\Math\Exception\RoundingNecessaryException;
use Brick\Money\Exception\UnknownCurrencyException;
use InvalidArgumentException;
use KollabsBooks\BookCatalog\Domain\Entity\Book;
use KollabsBooks\BookCatalog\Domain\Repository\BookRepositoryInterface;
use KollabsBooks\BookCatalog\Domain\ValueObject\Author;
use KollabsBooks\BookCatalog\Domain\ValueObject\Collection\BookCollection;
use KollabsBooks\BookCatalog\Domain\ValueObject\Stock;
use KollabsBooks\BookCatalog\Domain\ValueObject\Title;
use KollabsBooks\BookCatalog\Domain\ValueObject\Uuid;
use KollabsBooks\Shared\Domain\Exception\ConflictException;
use KollabsBooks\Shared\Domain\ValueObject\Price;

final class BookService implements BookServiceInterface
{
    private BookRepositoryInterface $bookRepository;

    public function __construct(BookRepositoryInterface $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    /**
     * @throws UnknownCurrencyException
     * @throws NumberFormatException
     * @throws RoundingNecessaryException
     * @throws InvalidArgumentException
     * @throws ConflictException
     */
    public function createBook(
        string $id,
        string $title,
        string $author,
        float $priceAmount,
        string $currency,
        int $stock
    ): Book {
        // Check if book already exists
        $existingBook = $this->bookRepository->findBookById(new Uuid($id));
        if ($existingBook) {
            throw new ConflictException('Book with this ID already exists');
        }

        $book = new Book(
            new Uuid($id),
            new Title($title),
            new Author($author),
            new Price($priceAmount, $currency),
            new Stock($stock)
        );

        $this->bookRepository->add($book);

        return $book;
    }

    /**
     * @throws UnknownCurrencyException
     * @throws NumberFormatException
     * @throws RoundingNecessaryException
     */
    public function getBook(string $id): ?Book
    {
        return $this->bookRepository->findBookById(new Uuid($id));
    }

    public function findAll(): BookCollection
    {
        return $this->bookRepository->findAll();
    }

    public function updateBook(string $id, string $title, string $author, float $priceAmount, string $currency, int $stock): Book
    {
        $book = new Book(
            new Uuid($id),
            new Title($title),
            new Author($author),
            new Price($priceAmount, $currency),
            new Stock($stock)
        );

        $this->bookRepository->store($book);

        return $book;
    }

    public function remove(string $id): bool
    {
        return $this->bookRepository->remove(new Uuid($id));
    }
}