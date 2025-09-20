<?php

declare(strict_types=1);

namespace App\Tests\Unit\Services;

use App\Entity\User;
use App\Entity\UserEmailBTree;
use App\Entity\UserIndexEveryCol;
use App\Services\CreateUser;
use App\Tests\CustomKernelTestCase;

final class CreateUserTest extends CustomKernelTestCase
{
    private CreateUser $service;

    public function setUp(): void
    {
        parent::setUp();
        $this->service = $this->getContainer()->get(CreateUser::class);
    }

    public function testCanInsertManyUsers()
    {
        $res = $this->service->insertManyUsers(User::class);
        dump($res);
        self::assertIsArray($res);
        $res = $this->service->insertManyUsers(UserEmailBTree::class);
        dump($res);
        self::assertIsArray($res);
        $res = $this->service->insertManyUsers(UserIndexEveryCol::class);
        dump($res);
        self::assertIsArray($res);
    }
}
