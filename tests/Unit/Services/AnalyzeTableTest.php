<?php

declare(strict_types=1);

namespace App\Tests\Unit\Services;

use App\Entity\Statistic;
use App\Entity\User;
use App\Entity\UserEmailBTree;
use App\Entity\UserIndexEveryCol;
use App\Services\AnalyzeTable;
use App\Services\UserService;
use App\Tests\CustomKernelTestCase;

final class AnalyzeTableTest extends CustomKernelTestCase
{
    private AnalyzeTable $analyzeTable;

    public function setUp(): void
    {
        parent::setUp();
        $this->analyzeTable = $this->getContainer()->get(AnalyzeTable::class);
    }

    public function testCanAnalyzeUsersTable()
    {
        self::assertCount(0, $this->entityManager->getRepository(User::class)->findAll());
        $res = $this->analyzeTable->getAnalysisAndData(User::class);
        dump($res);
        self::assertNotEmpty($res->queries);

        self::assertCount(0, $this->entityManager->getRepository(UserEmailBTree::class)->findAll());
        $res = $this->analyzeTable->getAnalysisAndData(UserEmailBTree::class);
        dump($res);
        self::assertNotEmpty($res->queries);

        self::assertCount(0, $this->entityManager->getRepository(UserIndexEveryCol::class)->findAll());
        $res = $this->analyzeTable->getAnalysisAndData(UserIndexEveryCol::class);
        dump($res);
        self::assertNotEmpty($res->queries);
    }

    public function testCanParseAnalysis()
    {
        self::assertCount(0, $this->entityManager->getRepository(User::class)->findAll());
        $res = $this->analyzeTable->getAnalysisAndData(User::class, 10);
        $stats = $this->entityManager->getRepository(Statistic::class)->findAll();

        self::assertCount(3, ($stats));

        self::assertEquals('users.insert.execution_time', $stats[0]->getName());
        self::assertEquals('users.select_all.execution_time', $stats[1]->getName());
        self::assertEquals('users.select_one.execution_time', $stats[2]->getName());

    }
}
