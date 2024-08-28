<?php

declare(strict_types=1);

namespace KollabsBooks\BookCatalog\Domain\ValueObject;

use InvalidArgumentException;
use Ramsey\Uuid\Uuid as RamseyUuid;

final class Uuid
{
    private string $value;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(string $value)
    {
        if (!(RamseyUuid::isValid($value))) {
            throw new InvalidArgumentException('Invalid UUID');
        }
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}