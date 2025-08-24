<?php

declare(strict_types=1);

namespace App\Services;

use App\Dto\TableAnalysisResult;

final readonly class AnalyzeTable
{
    public const array METHODS = [
        'findAll',
        'findByEmail',
    ];

    public function __construct(
        private AnalyzeQuery $analyzeQuery,
    ) {}

    public function getAnalysisAndData(string $class, array $methods = []): TableAnalysisResult
    {
        $methods = (count($methods) === 0) ? self::METHODS : $methods;
        $analyses = [];
        foreach ($methods as $method) {
            $analyses[] = $this->analyzeQuery->getAnalysisAndData($class, $method);
        }

        return new TableAnalysisResult($analyses, $class);
    }
}