<?php

namespace App\Entity;

use App\Repository\RoomRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RoomRepository::class)]
class Floor
{
    use Field\Id;
    use Field\Name;

    #[ORM\ManyToOne(inversedBy: 'spaces')]
    private Venue $venue;

    public function __toString(): string
    {
        return $this->venue->getName().' - '.$this->name;
    }

    public function getVenue(): Venue
    {
        return $this->venue;
    }

    public function setVenue(Venue $venue): void
    {
        $this->venue = $venue;
    }
}
