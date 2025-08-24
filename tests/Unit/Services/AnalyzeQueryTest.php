<?php

declare(strict_types=1);

namespace App\Tests\Unit\Services;

use App\Entity\User;
use App\Services\AnalyzeQuery;
use App\Tests\CustomKernelTestCase;

final class AnalyzeQueryTest extends CustomKernelTestCase
{
    private AnalyzeQuery $analyzeQuery;

    public function setUp(): void
    {
        parent::setUp();
        $this->analyzeQuery = $this->getContainer()->get(AnalyzeQuery::class);
    }

    public function testCanAnalyzeFindAll()
    {
        $res = $this->analyzeQuery->getAnalysisAndData(User::class, 'findAll');

        dump($res->analysis);
        self::assertEquals(1, 1);
    }

    public function testCanAnalyzeFindByEmail()
    {
        $res = $this->analyzeQuery->getAnalysisAndData(User::class, 'findByEmail');

        dump($res->analysis);
        self::assertEquals(1, 1);
    }
}