<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250824114505 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('create table users_email_btree (
                                id serial primary key,
                                email text not null default \'\' ,
                                name text not null default \'\',
                                age int not null default 18,
                                height int not null default 180,
                                sex boolean not null default true, -- true=M false=F
                                bio text not null default \'\',
                                password text not null default \'\', -- we will never query by this field
                                attributes json not null default \'{}\',
                                created_at timestamp with time zone not null default now(),
                                updated_at timestamp with time zone not null default now(),
                                deleted_at timestamp with time zone default null
                            )
        ');

        //
        //B-tree (сбалансированное дерево) — это самый распространенный тип индекса в PostgreSQL.
        // Он поддерживает все стандартные операции сравнения (>, <, >=, <=, =, <>) и может использоваться с большинством типов данных.
        // B-tree индексы могут быть использованы для сортировки, ограничений уникальности и поиска по диапазону значений.
        $this->addSql('CREATE UNIQUE INDEX ix_users_email_btree ON users_email_btree (email); ');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('drop table users_email_btree');
    }
}
