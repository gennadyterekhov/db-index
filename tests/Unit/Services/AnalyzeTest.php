<?php

declare(strict_types=1);

namespace App\Tests\Unit\Services;

use App\Dto\QueryAnalysisResult;
use App\Dto\TableAnalysisResult;
use App\Entity\User;
use App\Entity\UserEmailBTree;
use App\Entity\UserIndexEveryCol;
use App\Services\Analyze;
use App\Tests\CustomKernelTestCase;

final class AnalyzeTest extends CustomKernelTestCase
{
    private Analyze $service;

    public function setUp(): void
    {
        parent::setUp();
        $this->service = $this->getContainer()->get(Analyze::class);
    }

    public function testCanAnalyzeAllTables()
    {
        $res = $this->service->getAnalysisAndData();
        self::assertIsArray($res);
        self::assertArrayHasKey(User::class, $res);
        self::assertArrayHasKey(UserEmailBTree::class, $res);
        self::assertArrayHasKey(UserIndexEveryCol::class, $res);

        self::assertInstanceOf(TableAnalysisResult::class, $res[User::class]);

        self::assertIsArray($res[User::class]->queries);
        self::assertNotEmpty($res[User::class]->queries);
        self::assertInstanceOf(QueryAnalysisResult::class, $res[User::class]->queries[0]);
    }
}
