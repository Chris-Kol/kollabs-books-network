<?php

declare(strict_types=1);

namespace KollabsBooks\BookCatalog\Infrastructure\Persistence;

use InvalidArgumentException;
use KollabsBooks\BookCatalog\Domain\Entity\Book;
use KollabsBooks\BookCatalog\Domain\Repository\BookRepositoryInterface;
use KollabsBooks\BookCatalog\Domain\ValueObject\Author;
use KollabsBooks\BookCatalog\Domain\ValueObject\Collection\BookCollection;
use KollabsBooks\BookCatalog\Domain\ValueObject\Stock;
use KollabsBooks\BookCatalog\Domain\ValueObject\Title;
use KollabsBooks\BookCatalog\Domain\ValueObject\Uuid;
use KollabsBooks\Shared\Domain\ValueObject\Price;
use Pixie\QueryBuilder\QueryBuilderHandler;

final class SqlBookRepository implements BookRepositoryInterface
{
    private QueryBuilderHandler $qb;

    public function __construct(QueryBuilderHandler $qb)
    {
        $this->qb = $qb;
    }

    public function findAll(): BookCollection
    {
        $booksData = $this->qb->table('books')->orderBy('title')->get();
        $books = array_map(fn($bookData) => $this->createBookFromArray((array)$bookData), $booksData);
        return new BookCollection($books);
    }

    /**
     * @throws InvalidArgumentException
     */
    public function findBookById(Uuid $id): ?Book
    {
        $bookData = $this->qb->table('books')->where('id', $id->getValue())->first();
        return $bookData ? $this->createBookFromArray((array)$bookData) : null;
    }

    /**
     * @throws InvalidArgumentException
     */
    private function createBookFromArray(array $bookData): Book
    {
        try {
            return new Book(
                new Uuid($bookData['id']),
                new Title($bookData['title']),
                new Author($bookData['author']),
                new Price($bookData['price'], 'EUR'),
                new Stock((int)$bookData['stock'])
            );
        } catch (InvalidArgumentException $e) {
            throw new InvalidArgumentException('Invalid book data', 0, $e);
        }
    }

    public function store(Book $book): void
    {
        $data = [
            'id' => $book->getId()->getValue(),
            'title' => $book->getTitle()->getValue(),
            'author' => $book->getAuthor()->getName(),
            'price' => $book->getPrice()->getAmount(),
            'stock' => $book->getStock()->getValue()
        ];

        // Check if book exists
        $existing = $this->qb->table('books')->where('id', $book->getId()->getValue())->first();
        
        if ($existing) {
            // Update existing book
            $this->qb->table('books')->where('id', $book->getId()->getValue())->update([
                'title' => $data['title'],
                'author' => $data['author'],
                'price' => $data['price'],
                'stock' => $data['stock']
            ]);
        } else {
            // Insert new book
            $this->qb->table('books')->insert($data);
        }
    }

    public function add(Book $book): void
    {
        // Only insert, don't update - will fail if ID already exists
        $data = [
            'id' => $book->getId()->getValue(),
            'title' => $book->getTitle()->getValue(),
            'author' => $book->getAuthor()->getName(),
            'price' => $book->getPrice()->getAmount(),
            'stock' => $book->getStock()->getValue()
        ];

        $this->qb->table('books')->insert($data);
    }

    public function remove(Uuid $id): bool
    {
        // Use Pixie query builder for delete
        // Pixie returns a PDOStatement, we can get affected row count from it
        $statement = $this->qb->table('books')->where('id', $id->getValue())->delete();
        
        // Return true if any rows were affected (deleted)
        return $statement->rowCount() > 0;
    }
}