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

    #[ORM\Column(type: Types::TEXT)]
    protected ?string $email = null;

    #[ORM\Column(type: Types::TEXT)]
    protected ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    protected ?string $password = null;

    #[ORM\Column]
    protected array $attributes = [];

    #[ORM\Column(type: Types::DATETIMETZ_MUTABLE)]
    protected ?\DateTime $created_at = null;

    #[ORM\Column(type: Types::DATETIMETZ_MUTABLE)]
    protected ?\DateTime $updated_at = null;

    #[ORM\Column(type: Types::DATETIMETZ_MUTABLE, nullable: true)]
    protected ?\DateTime $deleted_at = null;
}
