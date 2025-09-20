<?php

declare(strict_types=1);

namespace App\Services;

use App\Dto\QueryAnalysisResult;

final class QueryKeeper
{
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
        return $this;
    }

    public function clearQueries(): QueryKeeper
    {
        $this->queries = [];
        return $this;
    }
}
