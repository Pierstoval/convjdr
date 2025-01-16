<?php

namespace App\Entity;

use App\Repository\RoomRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RoomRepository::class)]
class Floor
{
    use Field\Id;
    use Field\Name;

    #[ORM\ManyToOne(inversedBy: 'floors')]
    private Venue $venue;

    /**
     * @var Collection<Room>
     */
    #[ORM\OneToMany(targetEntity: Room::class, mappedBy: 'floor', cascade: ['persist', 'refresh'])]
    private Collection $rooms;

    public function __toString(): string
    {
        return $this->venue.' - '.$this->name;
    }

    public function refreshNestedRelations(): void
    {
        foreach ($this->rooms as $room) {
            $room->setFloor($this);
            $room->refreshNestedRelations();
        }
    }

    public function getVenue(): Venue
    {
        return $this->venue;
    }

    /**
     * @return Collection<Room>
     */
    public function getRooms(): Collection
    {
        return $this->rooms;
    }

    public function setVenue(Venue $venue): void
    {
        $this->venue = $venue;
    }

    public function addRoom(Room $room): void
    {
        if ($this->rooms->contains($room)) {
            return;
        }

        $this->rooms->add($room);
    }

    public function removeRoom(Room $room): void
    {
        if (!$this->rooms->contains($room)) {
            return;
        }

        $this->rooms->removeElement($room);
    }

    public function hasRoom(Room $room): bool
    {
        return $this->rooms->contains($room);
    }
}
