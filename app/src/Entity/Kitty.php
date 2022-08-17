<?php

namespace App\Entity;

use App\Repository\KittyRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: KittyRepository::class)]
class Kitty
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\Column(length: 255)]
    private string $intro;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $avatarUrl;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setIntro(string $intro): void
    {
        $this->intro = $intro;
    }

    public function getIntro(): string
    {
        return $this->intro;
    }

    public function setAvatarUrl(string $avatarUrl): void
    {
        $this->avatarUrl = $avatarUrl;
    }

    public function getAvatarUrl(): ?string
    {
        return $this->avatarUrl;
    }
}