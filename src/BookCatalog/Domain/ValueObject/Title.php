<?php

declare(strict_types=1);

namespace KollabsBooks\BookCatalog\Domain\ValueObject;

use KollabsBooks\Shared\Domain\Traits\NonEmptyStringTrait;

final class Title
{
    use NonEmptyStringTrait;

    private string $value;

    public function __construct(string $value)
    {
        $this->validateNonEmptyString($value);
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}