<?php

namespace App\Entity;

use App\Repository\BandRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;

#[ORM\Entity(repositoryClass: BandRepository::class)]
#[ApiResource]
class Band
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $picture = null;

    #[ORM\Column(nullable: true)]
    private ?int $creationYear = null;

    #[ORM\OneToMany(mappedBy: 'band', targetEntity: Album::class)]
    // Permet d'afficher la liste des albums par ordre chronologique
    #[ORM\OrderBy(["releasedYear" => "ASC"])]
    private Collection $albums;

    #[ORM\ManyToOne(inversedBy: 'bands')]
    private ?Country $country = null;

    #[ORM\ManyToOne(inversedBy: 'bands')]
    private ?MetalStyle $style = null;

    public function __construct()
    {
        $this->albums = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): static
    {
        $this->picture = $picture;

        return $this;
    }

    public function getCreationYear(): ?int
    {
        return $this->creationYear;
    }

    public function setCreationYear(?int $creationYear): static
    {
        $this->creationYear = $creationYear;

        return $this;
    }

    /**
     * @return Collection<int, Album>
     */
    public function getAlbums(): Collection
    {
        return $this->albums;
    }

    public function addAlbum(Album $album): static
    {
        if (!$this->albums->contains($album)) {
            $this->albums->add($album);
            $album->setBand($this);
        }

        return $this;
    }

    public function removeAlbum(Album $album): static
    {
        if ($this->albums->removeElement($album)) {
            // set the owning side to null (unless already changed)
            if ($album->getBand() === $this) {
                $album->setBand(null);
            }
        }

        return $this;
    }

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function getStyle(): ?MetalStyle
    {
        return $this->style;
    }

    public function setStyle(?MetalStyle $style): static
    {
        $this->style = $style;

        return $this;
    }
}
