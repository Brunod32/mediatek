<?php

namespace App\Entity;

use App\Repository\CountryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;

#[ORM\Entity(repositoryClass: CountryRepository::class)]
#[ApiResource]
class Country
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 25)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'country', targetEntity: Band::class)]
    private Collection $bands;

    #[ORM\OneToMany(mappedBy: 'Country', targetEntity: Writer::class)]
    private Collection $writers;

    public function __construct()
    {
        $this->bands = new ArrayCollection();
        $this->writers = new ArrayCollection();
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
            $band->setCountry($this);
        }

        return $this;
    }

    public function removeBand(Band $band): static
    {
        if ($this->bands->removeElement($band)) {
            // set the owning side to null (unless already changed)
            if ($band->getCountry() === $this) {
                $band->setCountry(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Writer>
     */
    public function getWriters(): Collection
    {
        return $this->writers;
    }

    public function addWriter(Writer $writer): static
    {
        if (!$this->writers->contains($writer)) {
            $this->writers->add($writer);
            $writer->setCountry($this);
        }

        return $this;
    }

    public function removeWriter(Writer $writer): static
    {
        if ($this->writers->removeElement($writer)) {
            // set the owning side to null (unless already changed)
            if ($writer->getCountry() === $this) {
                $writer->setCountry(null);
            }
        }

        return $this;
    }
}
