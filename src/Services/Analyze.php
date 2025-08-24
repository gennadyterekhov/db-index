<?php

declare(strict_types=1);

namespace App\Services;

use App\Entity\User;
use App\Entity\UserEmailBTree;

final readonly class Analyze
{
    public const array CLASSES = [
        User::class,
        UserEmailBTree::class,
    ];

    public function __construct(
        private AnalyzeTable $analyzeTable,
    ) {}

    public function getAnalysisAndData(string $class, array $methods = []): array
    {
        $tables = [];
        foreach (Analyze::CLASSES as $class) {
            $tables[$class] = $this->analyzeTable->getAnalysisAndData($class);
        }
        return $tables;
    }
}