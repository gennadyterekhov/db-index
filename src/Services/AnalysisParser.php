<?php

declare(strict_types=1);

namespace App\Services;

use App\Dto\QueryAnalysisParsed;
use App\Dto\QueryAnalysisResult;
use App\Entity\Statistic;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

final class AnalysisParser
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private LoggerInterface $logger,
    ) {}

    public function parse(QueryAnalysisResult $analysisResult): QueryAnalysisParsed
    {
        $tableName = '';
        $queryType = '';
        $feature = '';
        $planningTime = 0;
        $executionTime = 0;
        $this->logger->info('===');

        $this->logger->info(__METHOD__, $analysisResult->analysis);
        foreach ($analysisResult->analysis as $analysis) {
//            dump($analysis);
//            $this->logger->info(__METHOD__,[$analysis]);
            if (str_starts_with($analysis, 'Insert on') || str_starts_with($analysis, 'Seq Scan')) {
                $parts = explode('(cost', $analysis);
//                dump($parts[0]);
                $parts2 = explode(' on ', $parts[0]);
                $tableName = trim($parts2[1]);
                if (str_starts_with($analysis, 'Insert on')) {
                    $queryType = 'insert';
                }
                if (str_starts_with($analysis, 'Seq Scan')) {
                    $queryType = 'select_all';
                }
            }

            if (str_starts_with($analysis, 'Index Scan')) {
                $parts = explode('(cost', $analysis);
//                dump($parts[0]);
                $parts2 = explode(' on ', $parts[0]);
                $tableName = trim($parts2[1]);
                $queryType = 'select_one';
            }


            if (str_starts_with($analysis, '  Filter')) {
                $queryType = 'select_one';
            }

            if (str_starts_with($analysis, 'Planning Time:')) {
                $parts = explode('Planning Time:', $analysis);
                $parts2 = explode(' ms', $parts[1]);
                $planningTime = floatval(trim($parts2[0]));
            }

            if (str_starts_with($analysis, 'Execution Time: ')) {
                $parts = explode('Execution Time: ', $analysis);
                $parts2 = explode(' ms', $parts[1]);
                $executionTime = floatval(trim($parts2[0]));
            }
        }
        return new QueryAnalysisParsed(
            $tableName,
            $queryType,
            $feature,
            $planningTime,
            $executionTime,
        );
    }
}
