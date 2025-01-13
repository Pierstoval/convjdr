<?php

namespace App\Entity;

use App\Repository\AttendeeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AttendeeRepository::class)]
class Attendee
{
    use Field\Id;
    use Field\Name;

    #[ORM\Column]
    private int $numberOfAttendees = 0;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ScheduledAnimation $scheduledAnimation;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private User $registeredBy;

    public function getNumberOfAttendees(): int
    {
        return $this->numberOfAttendees;
    }

    public function setNumberOfAttendees(?int $numberOfAttendees): void
    {
        $this->numberOfAttendees = $numberOfAttendees ?: 0;
    }

    public function getScheduledAnimation(): ScheduledAnimation
    {
        return $this->scheduledAnimation;
    }

    public function setScheduledAnimation(ScheduledAnimation $scheduledAnimation): void
    {
        $this->scheduledAnimation = $scheduledAnimation;
    }

    public function getRegisteredBy(): User
    {
        return $this->registeredBy;
    }

    public function setRegisteredBy(User $registeredBy): void
    {
        $this->registeredBy = $registeredBy;
    }
}
