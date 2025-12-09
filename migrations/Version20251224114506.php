<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251224114506 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('create table statistic (
                                id serial primary key,
                                name text not null default \'\',
                                                                --value text not null default \'\',
                                value double precision not null default 0,
                                --value_json json not null default \'{}\',
                                created_at timestamp with time zone not null default now()
                            )
        ');

        $this->addSql("CREATE INDEX ix_statistic_index_name ON statistic (name); ");

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('drop table statistic');
    }
}
