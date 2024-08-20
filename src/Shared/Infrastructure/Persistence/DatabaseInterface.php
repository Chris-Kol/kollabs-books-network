<?php

declare(strict_types=1);

namespace KollabsBooks\Shared\Infrastructure\Persistence;

use Aura\Sql\Exception\CannotBindValue;

interface DatabaseInterface
{
    public function fetchAll(string $statement, array $values = []): array;
    public function fetchOne(string $statement, array $values = []): ?array;
    /**
     * @throws CannotBindValue
     */
    public function execute(string $statement, array $values = []): int;
    public function beginTransaction(): void;
    public function commit(): void;
    public function rollBack(): void;
}