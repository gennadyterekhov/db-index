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

    public function defaultData(): array
    {
        $name = $this->faker->firstName() . ' ' . $this->faker->lastName();
        $domain = uniqid() . $this->faker->word() . '.' . $this->faker->word();
        $email = str_replace(' ', '_', $name) . '@' . $domain;
        return [
            'email' => $email,
            'name' => $name,
            'age' => random_int(10, 60)
        ];
    }

    public function create($type)
    {
        return $this->createWData($type, $this->defaultData());
    }

    public function createWData($type, $dd)
    {
        $user = new $type();
        $user->setEmail($dd['email'])
            ->setName($dd['name'])
            ->setAttributes([
                'email' => $dd['email'],
                'name' => $dd['name'],
                'age' => $dd['age']
            ]);
        return $user;
    }
}