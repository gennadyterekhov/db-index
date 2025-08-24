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

    public function getAnalysisAndData(array $classes = []): array
    {
        $classes = (count($classes) === 0) ? self::CLASSES : $classes;

        $tables = [];
        foreach ($classes as $class) {
            $tables[$class] = $this->analyzeTable->getAnalysisAndData($class);
        }
        return $tables;
    }
}