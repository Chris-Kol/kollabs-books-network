<?php

declare(strict_types=1);

namespace KollabsBooks\BookCatalog\Domain\ValueObject;

use InvalidArgumentException;
use KollabsBooks\Shared\Domain\Traits\NonEmptyStringTrait;

final class Author
{
    use NonEmptyStringTrait;

    private string $name;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(string $name)
    {
        $this->validateNonEmptyString($name);
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }
}