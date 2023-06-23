<?php

namespace App\Entity;

use App\Repository\AlbumRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AlbumRepository::class)]
class Album
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column]
    private ?int $realesedYear = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $albumCover = null;

    #[ORM\ManyToOne(inversedBy: 'albums')]
    #[ORM\JoinColumn(onDelete:'cascade')]
    private ?Band $band = null;

    public function __toString()
    {
        return $this->title;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getRealesedYear(): ?int
    {
        return $this->realesedYear;
    }

    public function setRealesedYear(int $realesedYear): static
    {
        $this->realesedYear = $realesedYear;

        return $this;
    }

    public function getAlbumCover(): ?string
    {
        return $this->albumCover;
    }

    public function setAlbumCover(?string $albumCover): static
    {
        $this->albumCover = $albumCover;

        return $this;
    }

    public function getBand(): ?Band
    {
        return $this->band;
    }

    public function setBand(?Band $band): static
    {
        $this->band = $band;

        return $this;
    }
}
