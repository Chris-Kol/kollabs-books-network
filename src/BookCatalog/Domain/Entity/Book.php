<?php

declare(strict_types=1);

namespace KollabsBooks\BookCatalog\Domain\Entity;

use KollabsBooks\BookCatalog\Domain\Exception\InvalidBookDataException;
use KollabsBooks\BookCatalog\Domain\ValueObject\Author;
use KollabsBooks\BookCatalog\Domain\ValueObject\BookStatus;
use KollabsBooks\BookCatalog\Domain\ValueObject\Stock;
use KollabsBooks\BookCatalog\Domain\ValueObject\Title;
use KollabsBooks\BookCatalog\Domain\ValueObject\Uuid;
use KollabsBooks\Shared\Domain\ValueObject\Price;

final class Book
{
    private Uuid $id;
    private Title $title;
    private Author $author;
    private Price $price;
    private Stock $stock;
    private BookStatus $status;

    public function __construct(Uuid $id, Title $title, Author $author, Price $price, Stock $stock, ?BookStatus $status = null)
    {
        $this->validateBusinessRules($title, $author, $price, $stock);

        $this->id = $id;
        $this->title = $title;
        $this->author = $author;
        $this->price = $price;
        $this->stock = $stock;
        $this->status = $status ?? $this->determineStatus($stock);
    }

    private function validateBusinessRules(Title $title, Author $author, Price $price, Stock $stock): void
    {
        // Business rule: Books cannot be free unless it's a special promotion
        if ($price->isFree()) {
            throw new InvalidBookDataException('Books cannot be free without special authorization');
        }

        // Business rule: Stock cannot be negative
        if ($stock->getValue() < 0) {
            throw new InvalidBookDataException('Stock cannot be negative');
        }

        // Business rule: Very expensive books need special handling
        if ($price->isExpensive() && $stock->getValue() > 100) {
            throw new InvalidBookDataException('Expensive books (>50) cannot have stock over 100 without approval');
        }
    }

    private function determineStatus(Stock $stock): BookStatus
    {
        return $stock->getValue() > 0 ? BookStatus::available() : BookStatus::outOfStock();
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getTitle(): Title
    {
        return $this->title;
    }

    public function getAuthor(): Author
    {
        return $this->author;
    }

    public function getPrice(): Price
    {
        return $this->price;
    }

    public function getStock(): Stock
    {
        return $this->stock;
    }

    public function getStatus(): BookStatus
    {
        return $this->status;
    }

    public function isAvailable(): bool
    {
        return $this->status->isAvailable();
    }

    public function updateStock(Stock $newStock): void
    {
        $this->stock = $newStock;
        $this->status = $this->determineStatus($newStock);
    }

    public function changePrice(Price $newPrice): void
    {
        if ($newPrice->isFree()) {
            throw new InvalidBookDataException('Cannot change book price to free without authorization');
        }
        
        $this->price = $newPrice;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id->getValue(),
            'title' => $this->title->getValue(),
            'author' => $this->author->getName(),
            'price' => $this->price->toArray(),
            'stock' => $this->stock->getValue(),
            'status' => $this->status->getValue(),
            'available' => $this->isAvailable()
        ];
    }
}