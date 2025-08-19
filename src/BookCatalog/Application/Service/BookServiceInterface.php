<?php

declare(strict_types=1);

namespace KollabsBooks\BookCatalog\Application\Service;

use Brick\Math\Exception\NumberFormatException;
use Brick\Math\Exception\RoundingNecessaryException;
use Brick\Money\Exception\UnknownCurrencyException;
use KollabsBooks\BookCatalog\Domain\Entity\Book;
use KollabsBooks\BookCatalog\Domain\ValueObject\Collection\BookCollection;
use KollabsBooks\Shared\Domain\Exception\ConflictException;

interface BookServiceInterface
{
    /**
     * @throws UnknownCurrencyException
     * @throws NumberFormatException
     * @throws RoundingNecessaryException
     * @throws ConflictException
     */
    public function createBook(
        string $id,
        string $title,
        string $author,
        float $priceAmount,
        string $currency,
        int $stock
    ): Book;

    /**
     * @throws UnknownCurrencyException
     * @throws NumberFormatException
     * @throws RoundingNecessaryException
     */
    public function getBook(string $id): ?Book;
    public function findAll(): BookCollection;
    public function updateBook(string $id, string $title, string $author, float $priceAmount, string $currency, int $stock): Book;
    public function remove(string $id): bool;
}