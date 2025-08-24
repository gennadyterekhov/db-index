<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Generator;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;

#[AsCommand(name: 'app:create-users')]
final readonly class CreateUsersCommand
{
    public const int NUMBER_OF_USERS = 1000;

    public function __construct(
        private EntityManagerInterface $entityManager,
        private Generator $faker,
    ) {}

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->createUsers();
        return Command::SUCCESS;
    }

    private function createUsers(): void
    {
        for ($i = 0; $i < self::NUMBER_OF_USERS; $i++) {
            $user = $this->create1User();
            $this->entityManager->persist($user);
        }

        $this->entityManager->flush();
    }

    private function create1User(): User
    {
        $name = $this->faker->name();
        $email = str_replace(' ', '_', $name) . '@example.com';
        $user = new User();
        $user->setEmail($email)
            ->setName($name)
            ->setAttributes([
                'email' => $email,
                'name' => $name,
                'age' => random_int(10, 60)
            ]);
        return $user;
    }
}