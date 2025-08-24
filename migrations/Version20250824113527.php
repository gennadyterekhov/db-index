<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250824113527 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('create table user (
                                id serial primary key,
                                email text not null default \'\' ,
                                name text not null default \'\',
                                password text not null default \'\', -- we will never query by this field
                                attributes json not null default \'{}\',
                                created_at timestamp with time zone not null default now(),
                                updated_at timestamp with time zone not null default now(),
                                deleted_at timestamp with time zone default null
                            )
        ');


    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('drop table user');
    }
}
