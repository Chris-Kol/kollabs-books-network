<?php

declare(strict_types=1);

namespace KollabsBooks\BookCatalog\Infrastructure\Persistence;

use Aura\Sql\Exception\CannotBindValue;
use KollabsBooks\BookCatalog\Domain\Entity\Book;
use KollabsBooks\BookCatalog\Domain\Repository\BookRepositoryInterface;
use KollabsBooks\BookCatalog\Domain\ValueObject\Author;
use KollabsBooks\BookCatalog\Domain\ValueObject\Price;
use KollabsBooks\BookCatalog\Domain\ValueObject\Stock;
use KollabsBooks\BookCatalog\Domain\ValueObject\Title;
use KollabsBooks\BookCatalog\Domain\ValueObject\Uuid;
use KollabsBooks\Shared\Infrastructure\Persistence\DatabaseConnectionInterface;

class SqlBookRepository implements BookRepositoryInterface
{
    private DatabaseConnectionInterface $db;

    public function __construct(DatabaseConnectionInterface $db)
    {
        $this->db = $db;
    }

    public function findAll(): array
    {
        $booksData = $this->db->fetchAll('SELECT * FROM books');
        return array_map([$this, 'createBookFromArray'], $booksData);
    }

    public function findById(Uuid $id): ?Book
    {
        $statement = sprintf('SELECT * FROM books WHERE id = %s', $id->value());
        $bookData = $this->db->fetchOne($statement);
        return $bookData ? $this->createBookFromArray($bookData) : null;
    }

    private function createBookFromArray(array $bookData): Book
    {
        return new Book(
            new Uuid($bookData['id']),
            new Title($bookData['title']),
            new Author($bookData['author']),
            new Price((int)($bookData['price'] * 100), 'USD'),
            new Stock((int)$bookData['stock'])
        );
    }

    /**
     * @throws CannotBindValue
     */
    public function save(Book $book): void
    {
        $statement = sprintf(
            'INSERT INTO books (id, title, author, price, stock) VALUES (%s, %s, %s, %.02f, %d)',
            $book->getId()->value(),
            $book->getTitle()->getValue(),
            $book->getAuthor()->getName(),
            $book->getPrice()->getAmount() / 100,
            $book->getStock()->getValue()
        );
        $duplicateStatement = sprintf(
            'DUPLICATE KEY UPDATE title = %s, author = %s, price = %.02f, stock = %d',
            $book->getTitle()->getValue(),
            $book->getAuthor()->getName(),
            $book->getPrice()->getAmount() / 100,
            $book->getStock()->getValue()
        );
        $this->db->execute(implode(' ON ', [$statement, $duplicateStatement]));
    }
}