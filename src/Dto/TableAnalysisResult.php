<?php

declare(strict_types=1);

namespace App\Dto;

final readonly class TableAnalysisResult
{
    public function __construct(
        /** @var QueryAnalysisResult[] $queries */
        public array $queries,
        public string $class,
    ) {}
}