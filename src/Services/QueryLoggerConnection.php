<?php

declare(strict_types=1);

namespace App\Services;

use App\Dto\QueryAnalysisResult;
use Doctrine\DBAL\Driver\Connection;
use Doctrine\DBAL\Driver\Result;
use Doctrine\DBAL\Driver\Statement;
use Doctrine\DBAL\ParameterType;
use Psr\Log\LoggerInterface;

final readonly class QueryLoggerConnection implements Connection
{
    public function __construct(private Connection $connection, private LoggerInterface $logger, private QueryKeeper $queryKeeper) {}

    public function prepare(string $sql): Statement
    {
        return $this->connection->prepare($sql);
    }

    public function query(string $sql): Result
    {
        return $this->connection->query($sql);
    }

    public function logQuery(string $sql): bool
    {
//        $this->logger->debug('logging Query ', ['sql' => $sql]);

        if (!str_starts_with($sql, 'EXPLAIN ANALYZE') && !str_starts_with($sql, 'SELECT NEXTVAL') && $this->queryKeeper->enabled) {
            $explain = $this->connection->query('EXPLAIN ANALYZE ' . $sql, [])->fetchAllAssociative();
            $analysis = new QueryAnalysisResult('$method', $sql, array_column($explain, 'QUERY PLAN'), []);
            $this->queryKeeper->addQuery($analysis);
            return true;
        }
        return false;
    }

    public function quote($value, $type = ParameterType::STRING): string
    {
        return $this->connection->quote($value);
    }

    public function exec(string $sql): int
    {
        $executed = $this->logQuery($sql);
        if (!$executed) {
            return $this->connection->exec($sql);
        }
        return 0;
    }

    public function lastInsertId($name = null)
    {
        return $this->connection->lastInsertId($name);
    }

    public function beginTransaction(): bool
    {
        return $this->connection->beginTransaction();
    }

    public function commit(): bool
    {
        return $this->connection->commit();
    }

    public function rollBack(): bool
    {
        return $this->connection->rollBack();
    }

    public function getNativeConnection(): mixed
    {
        return $this->connection->getNativeConnection();
    }
}