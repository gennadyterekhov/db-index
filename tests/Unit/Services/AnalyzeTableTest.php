<?php

declare(strict_types=1);

namespace App\Tests\Unit\Services;

use App\Entity\User;
use App\Entity\UserEmailBTree;
use App\Entity\UserIndexEveryCol;
use App\Services\AnalyzeTable;
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
}
