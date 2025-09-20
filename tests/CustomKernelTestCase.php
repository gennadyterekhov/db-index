<?php

declare(strict_types=1);

namespace App\Tests;

use App\Entity\User;
use App\Entity\UserEmailBTree;
use App\Entity\UserIndexEveryCol;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Zenstruck\Foundry\Test\Factories;

class CustomKernelTestCase extends KernelTestCase
{
    use Factories;

    protected readonly UrlGeneratorInterface $router;
    protected readonly EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        parent::setUp();
        self::ensureKernelShutdown();
        $this->router = $this->getContainer()->get(UrlGeneratorInterface::class);
        $this->entityManager = $this->getContainer()->get(EntityManagerInterface::class);
        $purger = new ORMPurger($this->entityManager);
        $purger->purge();

        $users = $this->entityManager->getRepository(User::class)->findAll();
        self::assertCount(0, $users);
        self::assertCount(0, $this->entityManager->getRepository(UserEmailBTree::class)->findAll());
        self::assertCount(0, $this->entityManager->getRepository(UserIndexEveryCol::class)->findAll());
    }
}
