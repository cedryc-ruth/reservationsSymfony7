<?php

namespace App\Entity;

use App\Repository\TypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeRepository::class)]
#[ORM\Table(name:'types')]
class Type
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 60)]
    private ?string $type = null;

    #[ORM\OneToMany(targetEntity: ArtistType::class, mappedBy: 'type')]
    private Collection $artistTypes;

    public function __construct()
    {
        $this->artistTypes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

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
            $artistType->setType($this);
        }

        return $this;
    }

    public function removeArtistType(ArtistType $artistType): static
    {
        if ($this->artistTypes->removeElement($artistType)) {
            // set the owning side to null (unless already changed)
            if ($artistType->getType() === $this) {
                $artistType->setType(null);
            }
        }

        return $this;
    }
}
