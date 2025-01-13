<?php

namespace App\Entity;

use App\Repository\RoomRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RoomRepository::class)]
class Room
{
    use Field\Id;
    use Field\Name;

    #[ORM\ManyToOne()]
    private Floor $floor;

    #[ORM\Column]
    private int $maxNumberOfTables = 1;

    public function setMaxNumberOfTables(?int $maxNumberOfTables): void
    {
        $this->maxNumberOfTables = $maxNumberOfTables ?: 1;
    }

    public function getMaxNumberOfTables(): int
    {
        return $this->maxNumberOfTables;
    }

    public function getFloor(): Floor
    {
        return $this->floor;
    }

    public function setFloor(Floor $floor): void
    {
        $this->floor = $floor;
    }
}
