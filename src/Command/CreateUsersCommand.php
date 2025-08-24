<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\User;
use App\Entity\UserEmailBTree;
use App\Services\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:create-users')]
final class CreateUsersCommand extends Command
{
    public const int NUMBER_OF_USERS = 1;
    public const array CLASSES = [
        User::class,
        UserEmailBTree::class,
    ];

    private Generator $faker;

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly UserService $userService,
    )
    {
        parent::__construct();
        $this->faker = Factory::create();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->createUsers();
        return Command::SUCCESS;
    }

    private function createUsers(): void
    {
        for ($i = 0; $i < self::NUMBER_OF_USERS; $i++) {
            foreach (self::CLASSES as $class) {
                $this->entityManager->persist($this->userService->create($class));
            }
        }

        $this->entityManager->flush();
    }
}