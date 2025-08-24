<?php

declare(strict_types=1);

namespace App\Services;

use App\Dto\QueryAnalysisResult;
use Doctrine\DBAL\Logging\DebugStack;
use Doctrine\ORM\EntityManagerInterface;

final readonly class AnalyzeQuery
{
    public function __construct(
        private EntityManagerInterface $entityManager,

    ) {}

    public function getAnalysisAndData(string $class, string $method): QueryAnalysisResult
    {
        return $this->getAnalysisAndDataWithCustomFunc(
            fn() => $this->entityManager->getRepository($class)->$method(),
            $method,
        );
    }

    public function getAnalysisAndDataWithCustomFunc($func, $method = ''): QueryAnalysisResult
    {
        // Enable SQL logging
        $connection = $this->entityManager->getConnection();
        $connection->getConfiguration()->setSQLLogger(new DebugStack());

        // Execute your query
        $data = $func();
//        $data = $this->userRepository->findAll();

        // Get the executed queries and explain them
        $logger = $connection->getConfiguration()->getSQLLogger();
        $lastQuery = end($logger->queries);

        // Run EXPLAIN ANALYZE on the last query
        $explain = $connection->executeQuery('EXPLAIN ANALYZE ' . $lastQuery['sql'], $lastQuery['params'])
            ->fetchAllAssociative();

        return new QueryAnalysisResult($method, $lastQuery['sql'], $explain, $data);
    }
}