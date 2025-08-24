<?php

declare(strict_types=1);

namespace App\Tests\Unit\Services;

use App\Entity\User;
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

    public function testCanAnalyzeUsers()
    {
        $res = $this->analyzeTable->getAnalysisAndData(User::class);

        dump($res->queries);
        self::assertEquals(1, 1);
    }
}