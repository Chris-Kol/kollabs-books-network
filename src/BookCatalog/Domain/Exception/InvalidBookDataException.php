<?php

declare(strict_types=1);

namespace KollabsBooks\BookCatalog\Domain\Exception;

use Exception;

final class InvalidBookDataException extends Exception
{
    public function __construct(string $message, int $code = 0, ?Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}