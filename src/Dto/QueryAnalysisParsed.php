<?php

declare(strict_types=1);

namespace App\Dto;

final readonly class QueryAnalysisParsed
{
    public function __construct(
        public string $tableName = '',
        public string $queryType = '',
        public string $feature = '',
        public float $planningTime = 0,
        public float $executionTime = 0,
    ) {}
}
