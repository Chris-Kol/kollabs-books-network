<?php

declare(strict_types=1);

namespace KollabsBooks\BookCatalog\Domain\ValueObject;

use InvalidArgumentException;

final class BookStatus
{
    private const AVAILABLE = 'available';
    private const OUT_OF_STOCK = 'out_of_stock';
    private const DISCONTINUED = 'discontinued';

    private const VALID_STATUSES = [
        self::AVAILABLE,
        self::OUT_OF_STOCK,
        self::DISCONTINUED
    ];

    private string $status;

    public function __construct(string $status)
    {
        if (!in_array($status, self::VALID_STATUSES)) {
            throw new InvalidArgumentException('Invalid book status: ' . $status);
        }

        $this->status = $status;
    }

    public static function available(): self
    {
        return new self(self::AVAILABLE);
    }

    public static function outOfStock(): self
    {
        return new self(self::OUT_OF_STOCK);
    }

    public static function discontinued(): self
    {
        return new self(self::DISCONTINUED);
    }

    public function getValue(): string
    {
        return $this->status;
    }

    public function isAvailable(): bool
    {
        return $this->status === self::AVAILABLE;
    }

    public function isOutOfStock(): bool
    {
        return $this->status === self::OUT_OF_STOCK;
    }

    public function isDiscontinued(): bool
    {
        return $this->status === self::DISCONTINUED;
    }

    public function equals(BookStatus $other): bool
    {
        return $this->status === $other->status;
    }

    public function __toString(): string
    {
        return $this->status;
    }
}