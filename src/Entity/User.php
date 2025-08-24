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

    #[ORM\Column(type: Types::INTEGER, options: ['default' => 18])]
    protected ?int $age = 18;

    #[ORM\Column(type: Types::INTEGER, options: ['default' => 180])]
    protected ?int $height = 180;

    #[ORM\Column(type: Types::BOOLEAN, options: ['default' => true])]
    protected ?bool $sex = true;

    #[ORM\Column(type: Types::TEXT, options: ['default' => ''])]
    protected ?string $bio = '';

    #[ORM\Column(type: Types::TEXT, options: ['default' => ''])]
    protected ?string $password = '';

    #[ORM\Column]
    protected array $attributes = [];

    #[ORM\Column(type: Types::DATETIMETZ_MUTABLE, options: ['default' => new \DateTime()])]
    protected ?\DateTime $createdAt = null;

    #[ORM\Column(type: Types::DATETIMETZ_MUTABLE, options: ['default' => new \DateTime()])]
    protected ?\DateTime $updatedAt = null;

    #[ORM\Column(type: Types::DATETIMETZ_MUTABLE, nullable: true)]
    protected ?\DateTime $deletedAt = null;
}
