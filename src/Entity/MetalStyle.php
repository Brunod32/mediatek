<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\MetalStyleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MetalStyleRepository::class)]
#[ApiResource]
class MetalStyle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 25)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'style', targetEntity: Band::class)]
    private Collection $bands;

    public function __construct()
    {
        $this->bands = new ArrayCollection();
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

    /**
     * @return Collection<int, Band>
     */
    public function getBands(): Collection
    {
        return $this->bands;
    }

    public function addBand(Band $band): static
    {
        if (!$this->bands->contains($band)) {
            $this->bands->add($band);
            $band->setStyle($this);
        }

        return $this;
    }

    public function removeBand(Band $band): static
    {
        if ($this->bands->removeElement($band)) {
            // set the owning side to null (unless already changed)
            if ($band->getStyle() === $this) {
                $band->setStyle(null);
            }
        }

        return $this;
    }
}
