<?php

namespace App\Entity;

use App\Repository\EventVenueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EventVenueRepository::class)]
class Venue
{
    use Field\Id { __construct as generateId; }
    use Field\Name;

    #[ORM\Column(type: Types::TEXT)]
    private string $address = '';

    /**
     * @var Collection<Floor>
     */
    #[ORM\OneToMany(targetEntity: Floor::class, mappedBy: 'venue', cascade: ['persist', 'refresh'])]
    private Collection $floors;

    public function __construct()
    {
        $this->generateId();
        $this->floors = new ArrayCollection();
    }

    public function refreshNestedRelations(): void
    {
        foreach ($this->floors as $floor) {
            $floor->setVenue($this);
            $floor->refreshNestedRelations();
        }
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function setAddress(?string $address): void
    {
        $this->address = $address ?: '';
    }

    /**
     * @return Collection<Floor>
     */
    public function getFloors(): Collection
    {
        return $this->floors;
    }

    public function addFloor(Floor $floor): void
    {
        if ($this->floors->contains($floor)) {
            return;
        }

        $this->floors->add($floor);
    }

    public function removeFloor(Floor $floor): void
    {
        if (!$this->floors->contains($floor)) {
            return;
        }

        $this->floors->removeElement($floor);
    }

    public function hasFloor(Floor $floor): bool
    {
        return $this->floors->contains($floor);
    }
}
