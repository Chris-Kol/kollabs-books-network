<?php

declare(strict_types=1);

namespace KollabsBooks\BookCatalog\Domain\Entity;

use KollabsBooks\BookCatalog\Domain\ValueObject\Author;
use KollabsBooks\BookCatalog\Domain\ValueObject\Price;
use KollabsBooks\BookCatalog\Domain\ValueObject\Stock;
use KollabsBooks\BookCatalog\Domain\ValueObject\Title;
use KollabsBooks\BookCatalog\Domain\ValueObject\Uuid;

final class Book
{
    private Uuid $id;
    private Title $title;
    private Author $author;
    private Price $price;
    private Stock $stock;

    public function __construct(Uuid $id, Title $title, Author $author, Price $price, Stock $stock)
    {
        $this->id = $id;
        $this->title = $title;
        $this->author = $author;
        $this->price = $price;
        $this->stock = $stock;
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
}