<?php

declare(strict_types=1);

namespace App\Services;

use Doctrine\DBAL\Logging\DebugStack;
use Doctrine\ORM\EntityManagerInterface;

final readonly class AnalyzeQuery
{
    public function getAnalysisAndData(EntityManagerInterface $entityManager, $func): array
    {
        // Enable SQL logging
        $connection = $entityManager->getConnection();
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

        return [
            'data' => $data,
            'analysis' => $explain,
        ];
    }
}