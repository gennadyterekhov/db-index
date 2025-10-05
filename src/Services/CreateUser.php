<?php

declare(strict_types=1);

namespace App\Services;

use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Factory;
use Faker\Generator;
use Psr\Log\LoggerInterface;
use Throwable;

final readonly class CreateUser
{
    private Generator $faker;

    public function __construct(
        private EntityManagerInterface $entityManager,
        private LoggerInterface $logger,
        private Tables $tables,
    )
    {
        $this->faker = Factory::create();
    }

    /**
     * @throws Exception
     */
    public function insertManyUsers(string $entityClass, int $number)
    {
        $sql = $this->makeBigInsert($entityClass, $number);
        try {
            return $this->entityManager->getConnection()->executeStatement($sql);//->fetchAllAssociative();
        } catch (Throwable $exception) {
            $this->logger->error('could not insert', ['msg' => $exception->getMessage()]);
        }

        return [];
    }

    private function makeBigInsert(string $entityClass, int $number): string
    {
        $tableName = $this->tables->getTableName($entityClass);
        $sql = "insert into $tableName (email, name, age, height, sex, bio) values ";
        $valuesClauses = [];

        for ($i = 0; $i < $number; $i++) {
            $dd = $this->defaultData();
            $valuesClauses[] = $this->makeValuesClause($dd);
        }

        $valuesClause = implode(',', $valuesClauses);
        return $sql . $valuesClause;
    }

    private function makeValuesClause(array $data): string
    {
        $sex = $data['sex'] ? 'true' : 'false';
        return sprintf("('%s', '%s', %d, %d, %s, '%s')", $data['email'], $data['name'], $data['age'], $data['height'], $sex, $data['bio']);
    }

    private function defaultData(): array
    {
        $sex = $this->faker->boolean();
        $bio = $this->faker->text();

        $name = $this->faker->firstName($sex ? 'male' : 'female') . ' ' . $this->faker->lastName($sex ? 'male' : 'female');
        $name = str_replace('\'', '', $name);
        $name = str_replace('"', '', $name);

        $domain = uniqid($this->faker->unique()->bothify("????_")) . $this->faker->word() . '.com';
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

    private function create($type)
    {
        return $this->createWData($type, $this->defaultData());
    }

    private function createWData($type, $dd)
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

    /**
     * @throws Exception
     */
    private function clearTable(string $entityClass): void
    {
        $table = $this->tables->getTableName($entityClass);
        $this->entityManager->getConnection()->executeStatement("delete from $table ");
    }
}
