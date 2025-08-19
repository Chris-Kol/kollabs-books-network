<?php

declare(strict_types=1);

namespace KollabsBooks\Shared\Domain\ValueObject;

use InvalidArgumentException;

final class Price
{
    private float $amount;
    private string $currency;

    public function __construct(float $amount, string $currency)
    {
        if ($amount < 0) {
            throw new InvalidArgumentException('Price amount cannot be negative');
        }

        if (empty(trim($currency))) {
            throw new InvalidArgumentException('Currency cannot be empty');
        }

        // Basic currency validation
        if (!in_array(strtoupper($currency), ['USD', 'EUR', 'GBP', 'JPY'])) {
            throw new InvalidArgumentException('Unsupported currency: ' . $currency);
        }

        $this->amount = round($amount, 2); // Round to 2 decimal places
        $this->currency = strtoupper($currency);
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function isExpensive(): bool
    {
        return $this->amount > 50.0;
    }

    public function isFree(): bool
    {
        return $this->amount === 0.0;
    }

    public function equals(Price $other): bool
    {
        return $this->amount === $other->amount && $this->currency === $other->currency;
    }

    public function add(Price $other): Price
    {
        if ($this->currency !== $other->currency) {
            throw new InvalidArgumentException('Cannot add prices with different currencies');
        }

        return new Price($this->amount + $other->amount, $this->currency);
    }

    public function toArray(): array
    {
        return [
            'amount' => $this->amount,
            'currency' => $this->currency
        ];
    }

    public function __toString(): string
    {
        return sprintf('%.2f %s', $this->amount, $this->currency);
    }
}