<?php

declare(strict_types=1);

namespace KollabsBooks\Shared\Infrastructure\Persistence;

use Aura\Sql\Exception\CannotBindValue;
use Aura\Sql\ExtendedPdo;

class AuraSqlConnection implements DatabaseConnectionInterface
{
    private ExtendedPdo $pdo;

    public function __construct(string $dsn, string $username, string $password)
    {
        $this->pdo = new ExtendedPdo($dsn, $username, $password);
    }

    public function fetchAll(string $statement, array $values = []): array
    {
        return $this->pdo->fetchAll($statement, $values);
    }

    public function fetchOne(string $statement, array $values = []): ?array
    {
        $result = $this->pdo->fetchOne($statement, $values);
        return $result !== false ? $result : null;
    }

    /**
     * @throws CannotBindValue
     */
    public function execute(string $statement, array $values = []): int
    {
        return $this->pdo->perform($statement, $values)->rowCount();
    }

    public function beginTransaction(): void
    {
        $this->pdo->beginTransaction();
    }

    public function commit(): void
    {
        $this->pdo->commit();
    }

    public function rollBack(): void
    {
        $this->pdo->rollBack();
    }
}