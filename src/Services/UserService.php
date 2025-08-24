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
        $sex = $this->faker->boolean();
        $bio = $this->faker->text();

        $name = $this->faker->firstName($sex ? 'male' : 'female') . ' ' . $this->faker->lastName($sex ? 'male' : 'female');
        $domain = uniqid() . $this->faker->word() . '.com';
        $email = str_replace(' ', '_', $name) . '@' . $domain;
        return [
            'email' => $email,
            'name' => $name,
            'age' => random_int(10, 60),
            'height' => random_int(160, 200),
            'sex' => $sex,
            'bio' => $bio,
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
            ->setAge($dd['age'])
            ->setHeight($dd['height'])
            ->setSex($dd['sex'])
            ->setBio($dd['bio'])
            ->setAttributes($dd);
        return $user;
    }
}