<?php

namespace App\Entity;

use App\Repository\TimeSlotRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TimeSlotRepository::class)]
class TimeSlot
{
    use Field\Id;
    use Field\Name;
    use Field\StartEndDates;

    #[ORM\ManyToOne]
    private TimeSlotCategory $category;

    #[ORM\ManyToOne]
    private Event $event;

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
}
