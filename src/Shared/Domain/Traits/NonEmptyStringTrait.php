<?php

declare(strict_types=1);

namespace KollabsBooks\Shared\Domain\Traits;

trait NonEmptyStringTrait
{
    protected function validateNonEmptyString(string $value): void
    {
        if (empty(trim($value))) {
            throw new \InvalidArgumentException('Value cannot be empty');
        }
    }
}