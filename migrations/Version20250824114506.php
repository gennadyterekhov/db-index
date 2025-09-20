<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250824114506 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('create table users_index_every_col (
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
        $fields = [
            'id',
            'email',
            'name',
            'age',
            'height',
            'sex',
            'bio',
            'password',
            'created_at',
            'updated_at',
        ];
        foreach ($fields as $field) {
            $this->addSql("CREATE INDEX ix_users_index_every_col{$field} ON users_index_every_col ($field); ");
        }
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('drop table users_index_every_col');
    }
}
