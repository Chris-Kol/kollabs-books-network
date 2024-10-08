<?php

declare(strict_types=1);

namespace KollabsBooks\BookCatalog\Domain\ValueObject;

use InvalidArgumentException;

final class Stock
{
    private int $value;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(int $value)
    {
        if ($value < 0) {
            throw new InvalidArgumentException('Stock cannot be negative');
        }
        $this->value = $value;
    }

    public function getValue(): int
    {
        return $this->value;
    }
}