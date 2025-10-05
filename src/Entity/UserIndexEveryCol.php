<?php

namespace App\Entity;

use App\Repository\UserIndexEveryColRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserIndexEveryColRepository::class)]
#[ORM\Table(name: '`users_index_every_col`')]
class UserIndexEveryCol extends BaseUser
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "SEQUENCE")]
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

    #[ORM\Column(type: Types::DATETIME_MUTABLE, options: ['default' => new \DateTime()])]
    protected ?\DateTime $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, options: ['default' => new \DateTime()])]
    protected ?\DateTime $updatedAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    protected ?\DateTime $deletedAt = null;
}
