<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\TableAnalysisResult;
use App\Services\Analyze;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Throwable;

class MainController extends AbstractController
{
    public function __construct(
        private Analyze $analyze,
        private LoggerInterface $logger,
        private EntityManagerInterface $entityManager,

    ) {}

    #[Route('/')]
    public function main(): Response
    {
        $response = $this->getResponse();
        $purger = new ORMPurger($this->entityManager);
        $purger->purge();

        return $response;
    }

    #[Route('/{quantity}')]
    public function quantity(int $quantity): Response
    {
        $response = $this->getResponse($quantity);
        $purger = new ORMPurger($this->entityManager);
        $purger->purge();

        return $response;
    }

    #[Route('/{quantity}/nopurge')]
    public function noPurge(int $quantity): Response
    {
        $response = $this->getResponse($quantity);

        return $response;
    }

    public function getResponse(int $quantity = 10000): Response
    {
        $error = '';
        try {
            $analysis = $this->analyze->getAnalysisAndData([], $quantity);
        } catch (Throwable $exception) {
            $this->logger->error($exception->getMessage());
            $error = $exception->getMessage();
            $analysis[] = new TableAnalysisResult([], '');
        }

        return $this->render('main/main.html.twig',
            [
                'analysis' => $analysis,
                'analysisJson' => json_encode($analysis, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),

                'users' => '',
                'error' => $error,
            ]
        );
    }
}
