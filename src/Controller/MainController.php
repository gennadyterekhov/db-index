<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserEmailBTreeRepository;
use App\Repository\UserRepository;
use App\Services\Analyze;
use App\Services\AnalyzeQuery;
use App\Services\AnalyzeTable;
use Doctrine\DBAL\Logging\DebugStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    public function __construct(
        private UserRepository $userRepository,
        private UserEmailBTreeRepository $userEmailBTreeRepository,
        private AnalyzeQuery $analyzeQuery,
        private AnalyzeTable $analyzeTable,
        private Analyze $analyze,
    ) {}

    #[Route('/')]
    public function main(): Response
    {
        $analysis = $this->analyze->getAnalysisAndData();

        return $this->render('main/main.html.twig',
            [
                'analysis' => json_encode($analysis),
                'users' => '',
            ]
        );
    }
}