<?php

namespace App\Entity;

use App\Repository\TimeSlotRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TimeSlotRepository::class)]
class TimeSlot
{
    use Field\Id;
    use Field\StartEndDates;

    #[ORM\Column(name: 'name', type: Types::STRING, length: 255, nullable: false)]
    #[Assert\NotBlank(message: 'Please enter a name')]
    private ?string $name = '';

    #[ORM\ManyToOne]
    private TimeSlotCategory $category;

    #[ORM\ManyToOne]
    private Event $event;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank]
    private ?Table $table = null;

    public function __toString(): string
    {
        return sprintf("%s (⏲ %s ➡ %s)", $this->table, $this->startsAt?->format('Y-m-d H:i:s'), $this->endsAt?->format('Y-m-d H:i:s'));
    }

    #[Assert\IsTrue(message: 'Time slot start and end date must be included in start and end date from the associated Event.')]
    public function isEventDateValid(): bool
    {
        return $this->startsAt >= $this->event->startsAt
            && $this->startsAt <= $this->event->endsAt
            && $this->endsAt >= $this->event->startsAt
            && $this->endsAt <= $this->event->endsAt
        ;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name ?: '';
    }

    public function getCategory(): TimeSlotCategory
    {
        return $this->category;
    }

    public function setCategory(TimeSlotCategory $category): void
    {
        $this->category = $category;
    }

    public function getEvent(): Event
    {
        return $this->event;
    }

    public function setEvent(Event $event): void
    {
        $this->event = $event;
    }

    public function getTable(): ?Table
    {
        return $this->table;
    }

    public function setTable(?Table $table): void
    {
        $this->table = $table;
    }
}
