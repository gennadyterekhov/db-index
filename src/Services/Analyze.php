<?php

declare(strict_types=1);

namespace App\Services;

use App\Dto\TableAnalysisResult;
use App\Entity\User;
use App\Entity\UserEmailBTree;
use App\Entity\UserIndexEveryCol;
use Doctrine\DBAL\Exception;
use Psr\Log\LoggerInterface;

final readonly class Analyze
{
    public const array CLASSES = [
        User::class,
        UserEmailBTree::class,
        UserIndexEveryCol::class,
    ];

    public function __construct(
        private AnalyzeTable $analyzeTable,
        private LoggerInterface $logger,
    ) {}

    /**
     * @return TableAnalysisResult[]
     * @throws Exception
     */
    public function getAnalysisAndData(array $classes = [], int $quantity = 10000): array
    {
        $classes = (count($classes) === 0) ? self::CLASSES : $classes;

        $tables = [];
        foreach ($classes as $class) {
            $tables[$class] = $this->analyzeTable->getAnalysisAndData($class, $quantity);
        }
        return $tables;
    }
}