<?php

declare(strict_types=1);

namespace KollabsBooks\BookCatalog\Domain\ValueObject;

use Brick\Math\Exception\NumberFormatException;
use Brick\Math\Exception\RoundingNecessaryException;
use Brick\Money\Exception\UnknownCurrencyException;
use Brick\Money\Money;

final class Price
{
    private Money $money;

    /**
     * @throws UnknownCurrencyException
     * @throws RoundingNecessaryException
     * @throws NumberFormatException
     */
    public function __construct(float|int|string $amount, string $currency = 'EUR')
    {
        $this->money = Money::of($amount, $currency);
    }

    public function getAmountAsFloat(): float
    {
        return $this->money->getAmount()->toFloat();
    }

    public function getAmount(): string
    {
        return $this->money->getAmount()->__toString();
    }

    public function getCurrency(): string
    {
        return $this->money->getCurrency()->getCurrencyCode();
    }

    public function format(?string $locale = null): string
    {
        return $this->money->formatTo($locale ?? 'it_IT');
    }
}