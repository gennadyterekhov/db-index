<?php

declare(strict_types=1);

namespace App\Repository;

trait BaseRepo
{
    public function findByEmail(): array
    {
        $value = 'name@name.ru';
        return $this->createQueryBuilder('u')
            ->andWhere('u.email = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult();
    }
}