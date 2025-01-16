<?php

namespace App\Entity;

use App\Repository\RoomRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RoomRepository::class)]
class Room
{
    use Field\Id { __construct as generateId; }
    use Field\Name;

    #[ORM\ManyToOne(inversedBy: 'rooms')]
    private Floor $floor;

    /**
     * @var Collection<Table>
     */
    #[ORM\OneToMany(targetEntity: Table::class, mappedBy: 'room', cascade: ['persist', 'refresh'])]
    private Collection $tables;

    public function __construct()
    {
        $this->generateId();
        $this->tables = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->floor.' - '.$this->name;
    }

    public function refreshNestedRelations(): void
    {
        foreach ($this->tables as $table) {
            $table->setRoom($this);
        }
    }

    public function getFloor(): Floor
    {
        return $this->floor;
    }

    public function setFloor(Floor $floor): void
    {
        $this->floor = $floor;
    }

    /**
     * @return Collection<Table>
     */
    public function getTables(): Collection
    {
        return $this->tables;
    }

    public function addTable(Table $table): void
    {
        if ($this->tables->contains($table)) {
            return;
        }

        $this->tables->add($table);
    }

    public function removeTable(Table $table): void
    {
        if (!$this->tables->contains($table)) {
            return;
        }

        $this->tables->removeElement($table);
    }

    public function hasTable(Table $table): bool
    {
        return $this->tables->contains($table);
    }
}
