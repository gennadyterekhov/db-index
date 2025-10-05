<?php

declare(strict_types=1);

namespace App\Services;

use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;

final readonly class UserService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private Tables $tables,
        private CreateUser $createUser,
    ) {}

    /**
     * @throws Exception
     */
    public function insertManyUsers(string $entityClass, int $quantity = 10000)
    {
        return $this->createUser->insertManyUsers($entityClass, $quantity);
    }

    /**
     * @throws Exception
     */
    public function findByEmail(string $entityClass, string $email)
    {
        $tableName = $this->tables->getTableName($entityClass);

        $sql = "select * from $tableName where email = '$email'";
        return $this->entityManager->getConnection()->executeStatement($sql);
        return $this->entityManager->getConnection()->executeQuery($sql)->fetchAllAssociative();
    }

    /**
     * @throws Exception
     */
    public function findAll(string $entityClass)
    {
        $tableName = $this->tables->getTableName($entityClass);

        $sql = "select * from $tableName";
        return $this->entityManager->getConnection()->executeStatement($sql);
        return $this->entityManager->getConnection()->executeQuery($sql)->fetchAllAssociative();
    }
}
