<?php

declare(strict_types=1);

namespace KollabsBooks\BookCatalog\Domain\Exception;

use Exception;

final class BookAlreadyExistsException extends Exception
{
    public function __construct(string $bookId, int $code = 0, ?Exception $previous = null)
    {
        $message = sprintf('Book with ID "%s" already exists', $bookId);
        parent::__construct($message, $code, $previous);
    }
}