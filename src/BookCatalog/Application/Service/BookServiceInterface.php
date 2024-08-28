<?php

declare(strict_types=1);

namespace KollabsBooks\BookCatalog\Application\Service;

use Brick\Math\Exception\NumberFormatException;
use Brick\Math\Exception\RoundingNecessaryException;
use Brick\Money\Exception\UnknownCurrencyException;
use KollabsBooks\BookCatalog\Domain\Entity\Book;
use KollabsBooks\BookCatalog\Domain\ValueObject\Collection\BookCollection;

interface BookServiceInterface
{
    /**
     * @throws UnknownCurrencyException
     * @throws NumberFormatException
     * @throws RoundingNecessaryException
     */
    public function createBook(
        string $id,
        string $title,
        string $author,
        int $priceAmount,
        string $currency,
        int $stock
    ): Book;

    /**
     * @throws UnknownCurrencyException
     * @throws NumberFormatException
     * @throws RoundingNecessaryException
     */
    public function getBook(string $id): ?Book;
    public function getAllBooks(): BookCollection;
}