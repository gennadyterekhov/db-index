<?php

declare(strict_types=1);

namespace App\Services;

use App\Dto\QueryAnalysisResult;
use Doctrine\ORM\EntityManagerInterface;

final readonly class AnalyzeQuery
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private UserService $userService,
        private QueryKeeper $queryKeeper,
    ) {}

    /**
     * @return QueryAnalysisResult[]
     */
    public function getAnalysisAndData(string $class, string $method, bool $isEntity = true, string $serviceClass = ''): array
    {
        if ($isEntity) {
            return $this->getAnalysisAndDataWithCustomFunc(
                fn() => $this->entityManager->getRepository($class)->$method(),
                $method,
            );
        } else {
            return $this->getAnalysisAndDataWithCustomFunc(
                fn() => $this->userService->$method($class),
                $method,
            );
        }
    }

    /**
     * @return QueryAnalysisResult[]
     */
    private function getAnalysisAndDataWithCustomFunc($func, $method = ''): array
    {
        $this->queryKeeper->clearQueries();
        $this->queryKeeper->enabled = true;
        $data = $func();
        $this->queryKeeper->enabled = false;

        return $this->queryKeeper->getQueries();
    }
}
