<?php

declare(strict_types=1);

namespace KollabsBooks\BookCatalog\Domain\Entity;

use KollabsBooks\Shared\Domain\ValueObject\Uuid;
use KollabsBooks\Shared\Domain\ValueObject\Title;
use KollabsBooks\Shared\Domain\ValueObject\Price;

final class Book
{
    private Uuid $id;
    private Title $title;
    private string $author;
    private Price $price;
    private int $stock;

    public function __construct(Uuid $id, Title $title, string $author, Price $price, int $stock)
    {
        $this->id = $id;
        $this->title = $title;
        $this->author = $author;
        $this->price = $price;
        $this->setStock($stock);
    }

    public function id(): Uuid
    {
        return $this->id;
    }

    public function title(): Title
    {
        return $this->title;
    }

    public function author(): string
    {
        return $this->author;
    }

    public function price(): Price
    {
        return $this->price;
    }

    public function stock(): int
    {
        return $this->stock;
    }

    public function setStock(int $stock): void
    {
        if ($stock < 0) {
            throw new \InvalidArgumentException('Stock cannot be negative');
        }
        $this->stock = $stock;
    }
}