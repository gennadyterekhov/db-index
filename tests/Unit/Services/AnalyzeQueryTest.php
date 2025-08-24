<?php

declare(strict_types=1);

namespace App\Tests\Unit\Services;

use App\Tests\CustomKernelTestCase;

final class AnalyzeQueryTest extends CustomKernelTestCase
{
    public function testCanRunTest()
    {
        self::assertEquals(1, 1);
    }
}