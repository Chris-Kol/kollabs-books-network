<?php

declare(strict_types=1);

namespace KollabsBooks\Shared\Domain\Traits;

use InvalidArgumentException;

trait NonEmptyStringTrait
{
    /**
     * @throws InvalidArgumentException
     */
    protected function validateNonEmptyString(string $value): void
    {
        if (empty(trim($value))) {
            throw new InvalidArgumentException('Value cannot be empty');
        }
    }
}