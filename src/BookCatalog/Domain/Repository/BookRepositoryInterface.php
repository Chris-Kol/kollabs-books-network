<?php

declare(strict_types=1);

namespace KollabsBooks\BookCatalog\Domain\Repository;

use Brick\Math\Exception\NumberFormatException;
use Brick\Math\Exception\RoundingNecessaryException;
use Brick\Money\Exception\UnknownCurrencyException;
use KollabsBooks\BookCatalog\Domain\Entity\Book;
use KollabsBooks\BookCatalog\Domain\ValueObject\Collection\BookCollection;
use KollabsBooks\BookCatalog\Domain\ValueObject\Uuid;

interface BookRepositoryInterface
{
    /**
     * @throws UnknownCurrencyException
     * @throws NumberFormatException
     * @throws RoundingNecessaryException
     */
    public function findById(Uuid $id): ?Book;
    public function save(Book $book): void;
    public function findAll(): BookCollection;
}