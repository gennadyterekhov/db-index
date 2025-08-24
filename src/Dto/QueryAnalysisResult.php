<?php

declare(strict_types=1);

namespace App\Dto;

final readonly class QueryAnalysisResult
{
    public function __construct(
        public string $method,
        public string $sql,
        public array $analysis,
        public array $data,
    ) {}
}