<?php

declare(strict_types=1);

namespace App\Services;

use App\Dto\TableAnalysisResult;
use Doctrine\ORM\EntityManagerInterface;

final readonly class AnalyzeTable
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private AnalyzeQuery $analyzeQuery,
    ) {}

    public function getAnalysisAndData(EntityManagerInterface $repo, string $class): TableAnalysisResult
    {
        $repoMethods = [
            'findAll',
        ];
        $analyses = [];
        foreach ($repoMethods as $method) {
            $analyses[] = $this->analyzeQuery->getAnalysisAndData(
                $this->entityManager,
                fn() => $repo->$method(),
            );
        }

        return new TableAnalysisResult($analyses, $class);
    }
}