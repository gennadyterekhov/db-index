<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class UserFixtures extends Fixture
{
    public const NUMBER_OF_USERS = 1000;

    public function load(ObjectManager $manager,): void
    {
        $faker = (new Factory())->create();

        for ($i = 0; $i < self::NUMBER_OF_USERS; $i++) {
            $user = $this->create1User($manager, $faker);
            $manager->persist($user);
        }

        $manager->flush();
    }

    private function create1User(ObjectManager $manager, Generator $faker): User
    {
        $name = $faker->name();
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
