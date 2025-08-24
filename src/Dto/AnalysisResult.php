<?php

declare(strict_types=1);

namespace App\Dto;

final readonly class AnalysisResult
{
    public function __construct(
        public string $sql,
        public array $analysis,
        public array $data,
    ) {}
}