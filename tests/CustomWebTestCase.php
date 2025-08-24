<?php

declare(strict_types=1);

namespace App\Tests;

use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Zenstruck\Foundry\Test\Factories;

class CustomWebTestCase extends WebTestCase
{
    use Factories;

    protected readonly KernelBrowser $client;
    protected readonly UrlGeneratorInterface $router;
    protected readonly EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        parent::setUp();
        self::ensureKernelShutdown();
        $this->client = $this->createClient();
        $this->router = $this->getContainer()->get(UrlGeneratorInterface::class);
        $this->entityManager = $this->getContainer()->get(EntityManagerInterface::class);
        $purger = new ORMPurger($this->entityManager);
        $purger->purge();
    }
}
