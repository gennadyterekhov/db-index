<?php

declare(strict_types=1);

namespace App\Services;

use App\Dto\QueryAnalysisResult;
use App\Dto\TableAnalysisResult;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;

final readonly class AnalyzeTable
{
    public function __construct(
        private QueryKeeper $queryKeeper,
        private EntityManagerInterface $entityManager,
        private UserService $userService,
        private LoggerInterface $logger,

    ) {}

    /**
     * @throws Exception
     */
    public function getAnalysisAndData(string $class, int $quantity = 10000): TableAnalysisResult
    {
        $this->logger->info(__METHOD__, ['class' => $class]);

        $queryAnalysisResults = [];
        $this->queryKeeper->enabled = true;
        $this->queryKeeper->clearQueries();

        $this->logger->info(__METHOD__, ['method' => 'insert']);

        $this->userService->insertManyUsers($class, $quantity);
        $queryAnalysisResults = [...$queryAnalysisResults, ...$this->queryKeeper->getQueries()];
        $this->queryKeeper->clearQueries();

        $this->logger->info(__METHOD__, ['method' => 'findAll']);

//        $this->entityManager->getRepository($class)->findAll();
        $this->userService->findAll($class);
        $queryAnalysisResults = [...$queryAnalysisResults, ...$this->queryKeeper->getQueries()];

        $this->queryKeeper->clearQueries();

        $this->logger->info(__METHOD__, ['method' => 'findByEmail']);

        $this->userService->findByEmail($class, 'name@email.ru');
        $queryAnalysisResults = [...$queryAnalysisResults, ...$this->queryKeeper->getQueries()];
        $this->queryKeeper->clearQueries();

        $this->queryKeeper->enabled = false;

        if (count($queryAnalysisResults) === 0) {
            $queryAnalysisResults[] = new QueryAnalysisResult();
        }

        return new TableAnalysisResult($queryAnalysisResults, $class);
    }
}
