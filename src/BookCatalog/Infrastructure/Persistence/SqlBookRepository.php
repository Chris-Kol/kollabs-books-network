<?php

declare(strict_types=1);

namespace KollabsBooks\BookCatalog\Infrastructure\Persistence;

use Aura\Sql\Exception\CannotBindValue;
use Aura\SqlQuery\QueryFactory;
use Brick\Math\Exception\NumberFormatException;
use Brick\Math\Exception\RoundingNecessaryException;
use Brick\Money\Exception\UnknownCurrencyException;
use KollabsBooks\BookCatalog\Domain\Entity\Book;
use KollabsBooks\BookCatalog\Domain\Repository\BookRepositoryInterface;
use KollabsBooks\BookCatalog\Domain\ValueObject\Author;
use KollabsBooks\BookCatalog\Domain\ValueObject\Collection\BookCollection;
use KollabsBooks\BookCatalog\Domain\ValueObject\Price;
use KollabsBooks\BookCatalog\Domain\ValueObject\Stock;
use KollabsBooks\BookCatalog\Domain\ValueObject\Title;
use KollabsBooks\BookCatalog\Domain\ValueObject\Uuid;
use KollabsBooks\Shared\Infrastructure\Persistence\DatabaseInterface;

final class SqlBookRepository implements BookRepositoryInterface
{
    private DatabaseInterface $db;
    private QueryFactory $queryFactory;

    public function __construct(DatabaseInterface $db)
    {
        $this->queryFactory = new QueryFactory('mysql');
        $this->db = $db;
    }

    public function findAll(): BookCollection
    {
        $selectQuery = $this->queryFactory->newSelect();
        $selectQuery->cols(['*'])->from('books');
        $booksData = $this->db->fetchAll($selectQuery->getStatement());
        $books = array_map([$this, 'createBookFromArray'], $booksData);
        return new BookCollection($books);
    }

    /**
     * @throws UnknownCurrencyException
     * @throws NumberFormatException
     * @throws RoundingNecessaryException
     */
    public function findById(Uuid $id): ?Book
    {
        $selectQuery = $this->queryFactory->newSelect();
        $selectQuery->cols(['*'])->from('books')->where('id = :id')->bindValue('id', $id->getValue());
        $bookData = $this->db->fetchOne($selectQuery->getStatement());
        return $bookData ? $this->createBookFromArray($bookData) : null;
    }

    /**
     * @throws UnknownCurrencyException
     * @throws NumberFormatException
     * @throws RoundingNecessaryException
     */
    private function createBookFromArray(array $bookData): Book
    {
        return new Book(
            new Uuid($bookData['id']),
            new Title($bookData['title']),
            new Author($bookData['author']),
            new Price((int)($bookData['price'] * 100), 'EUR'),
            new Stock((int)$bookData['stock'])
        );
    }

    /**
     * @throws CannotBindValue
     */
    public function save(Book $book): void
    {
        $insertQuery = $this->queryFactory->newInsert();
        $insertQuery->into('books')->cols([
            'id' => $book->getId()->getValue(),
            'title' => $book->getTitle()->getValue(),
            'author' => $book->getAuthor()->getName(),
            'price' => $book->getPrice()->getAmountAsFloat() / 100,
            'stock' => $book->getStock()->getValue()
        ])->onDuplicateKeyUpdateCols([
            'title' => $book->getTitle()->getValue(),
            'author' => $book->getAuthor()->getName(),
            'price' => $book->getPrice()->getAmountAsFloat() / 100,
            'stock' => $book->getStock()->getValue()
        ]);

        $this->db->execute($insertQuery->getStatement());
    }
}