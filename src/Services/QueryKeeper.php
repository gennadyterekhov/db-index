<?php

declare(strict_types=1);

namespace App\Services;

use App\Dto\QueryAnalysisResult;
use App\Entity\Statistic;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

final class QueryKeeper
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private LoggerInterface $logger,
        private AnalysisParser $analysisParser,
    ) {}

    public bool $enabled = false;

    /** @var QueryAnalysisResult[] */
    private array $queries = [];

    /**
     * @return QueryAnalysisResult[]
     */
    public function getQueries(): array
    {
        return $this->queries;
    }

    public function addQuery(QueryAnalysisResult $analysisResult): QueryKeeper
    {
        assert($analysisResult instanceof QueryAnalysisResult);
        $this->queries[] = $analysisResult;
        $this->saveStat($analysisResult);
        return $this;
    }

    private function saveStat(QueryAnalysisResult $analysisResult): QueryKeeper
    {
        $parsed = $this->analysisParser->parse($analysisResult);
        $name = $parsed->tableName . '.' . $parsed->queryType . '.execution_time';
        $stat = new Statistic($name, $parsed->executionTime);
        $this->entityManager->persist($stat);
        $this->entityManager->flush();

        return $this;
    }

    public function clearQueries(): QueryKeeper
    {
        $this->queries = [];
        return $this;
    }
}
