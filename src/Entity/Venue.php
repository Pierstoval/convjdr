<?php

namespace App\Entity;

use App\Entity\Field\Id;
use App\Entity\Field\Name;
use App\Repository\EventVenueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EventVenueRepository::class)]
class Venue
{
    use Id { __construct as generateId; }
    use Name;

    #[ORM\Column(type: Types::TEXT)]
    private string $address = '';

    /**
     * @var Collection<Floor>
     */
    #[ORM\OneToMany(targetEntity: Floor::class, mappedBy: 'venue')]
    private Collection $floors;

    public function __construct()
    {
        $this->generateId();
        $this->floors = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->name;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function setAddress(?string $address): void
    {
        $this->address = $address ?: '';
    }
    public function getFloors(): Collection
    {
        return $this->floors;
    }

    public function addSpace(Floor $space): void
    {
        if ($this->floors->contains($space)) {
            return;
        }

        $this->floors->add($space);
    }

    public function removeSpace(Floor $space): void
    {
        if (!$this->floors->contains($space)) {
            return;
        }

        $this->floors->removeElement($space);
    }

    public function hasSpace(Floor $space): bool
    {
        return $this->floors->contains($space);
    }
}
