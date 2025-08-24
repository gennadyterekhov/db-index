<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`users`')]
class User extends BaseUser
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected ?int $id = null;

    #[ORM\Column(type: Types::TEXT, options: ['default' => ''])]
    protected ?string $email = '';

    #[ORM\Column(type: Types::TEXT, options: ['default' => ''])]
    protected ?string $name = '';

    #[ORM\Column(type: Types::TEXT, options: ['default' => ''])]
    protected ?string $password = '';

    #[ORM\Column]
    protected array $attributes = [];

    #[ORM\Column(type: Types::DATETIMETZ_MUTABLE, options: ['default' => new \DateTime()])]
    protected ?\DateTime $created_at = null;

    #[ORM\Column(type: Types::DATETIMETZ_MUTABLE, options: ['default' => new \DateTime()])]
    protected ?\DateTime $updated_at = null;

    #[ORM\Column(type: Types::DATETIMETZ_MUTABLE, nullable: true)]
    protected ?\DateTime $deleted_at = null;
}
