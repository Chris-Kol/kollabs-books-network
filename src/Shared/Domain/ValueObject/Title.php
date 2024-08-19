<?php

declare(strict_types=1);

namespace KollabsBooks\Shared\Domain\ValueObject;

final class Title
{
    private string $value;

    public function __construct(string $value)
    {
        if (empty(trim($value))) {
            throw new \InvalidArgumentException('Title cannot be empty');
        }
        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }
}