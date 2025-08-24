<?php

declare(strict_types=1);

namespace App\Services;

use App\Entity\User;
use Faker\Factory;
use Faker\Generator;

final readonly class UserService
{
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function create($type): User
    {
        $name = $this->faker->firstName() . ' ' . $this->faker->lastName();
        $domain = uniqid() . $this->faker->word() . '.' . $this->faker->word();
        $email = str_replace(' ', '_', $name) . '@' . $domain;
        $user = new $type();
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