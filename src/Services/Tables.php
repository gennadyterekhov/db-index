<?php

declare(strict_types=1);

namespace App\Services;

use App\Entity\User;
use App\Entity\UserEmailBTree;
use App\Entity\UserIndexEveryCol;

final readonly class Tables
{
    public function getTableName(string $entityClass): string
    {
        if ($entityClass === User::class) {
            return '"users"';
        }
        if ($entityClass === UserEmailBTree::class) {
            return '"users_email_btree"';
        }
        if ($entityClass === UserIndexEveryCol::class) {
            return '"users_index_every_col"';
        }
        return $entityClass;
    }
}
