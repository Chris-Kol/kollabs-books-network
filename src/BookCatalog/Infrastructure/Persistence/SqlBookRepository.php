<?php

declare(strict_types=1);

namespace KollabsBooks\BookCatalog\Infrastructure\Persistence;

use Aura\Sql\Exception\CannotBindValue;
use KollabsBooks\BookCatalog\Domain\Entity\Book;
use KollabsBooks\BookCatalog\Domain\Repository\BookRepositoryInterface;
use KollabsBooks\Shared\Domain\ValueObject\Price;
use KollabsBooks\Shared\Domain\ValueObject\Title;
use KollabsBooks\Shared\Domain\ValueObject\Uuid;
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
            $bookData['author'],
            new Price((int)($bookData['price'] * 100), 'USD'),
            (int)$bookData['stock']
        );
    }

    /**
     * @throws CannotBindValue
     */
    public function save(Book $book): void
    {
        $statement = sprintf(
            'INSERT INTO books (id, title, author, price, stock) VALUES (%s, %s, %s, %.02f, %d)',
            $book->id()->value(),
            $book->title()->value(),
            $book->author(),
            $book->price()->amount() / 100,
            $book->stock()
        );
        $duplicateStatement = sprintf(
            'DUPLICATE KEY UPDATE title = %s, author = %s, price = %.02f, stock = %d',
            $book->title()->value(),
            $book->author(),
            $book->price()->amount() / 100,
            $book->stock()
        );
        $this->db->execute(implode(' ON ', [$statement, $duplicateStatement]));
    }
}