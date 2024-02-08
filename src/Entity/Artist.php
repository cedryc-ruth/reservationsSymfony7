<?php

namespace App\Entity;

use App\Repository\ArtistRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArtistRepository::class)]
#[ORM\Table(name:'artists')]
class Artist
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 60)]
    private ?string $firstname = null;

    #[ORM\Column(length: 60)]
    private ?string $lastname = null;

    #[ORM\OneToMany(targetEntity: ArtistType::class, mappedBy: 'artist')]
    private Collection $artistTypes;

    public function __construct()
    {
        $this->artistTypes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * @return Collection<int, ArtistType>
     */
    public function getArtistTypes(): Collection
    {
        return $this->artistTypes;
    }

    public function addArtistType(ArtistType $artistType): static
    {
        if (!$this->artistTypes->contains($artistType)) {
            $this->artistTypes->add($artistType);
            $artistType->setArtist($this);
        }

        return $this;
    }

    public function removeArtistType(ArtistType $artistType): static
    {
        if ($this->artistTypes->removeElement($artistType)) {
            // set the owning side to null (unless already changed)
            if ($artistType->getArtist() === $this) {
                $artistType->setArtist(null);
            }
        }

        return $this;
    }
}
