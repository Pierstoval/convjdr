<?php

namespace App\Entity;

use App\Repository\AttendeeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AttendeeRepository::class)]
class Attendee
{
    use Field\Id;
    use Field\Name;

    #[ORM\Column(name: 'number_of_attendees', type: Types::INTEGER, nullable: false)]
    private int $numberOfAttendees = 0;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: 'scheduled_animation_id', referencedColumnName: 'id', nullable: false)]
    private ScheduledAnimation $scheduledAnimation;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: 'registered_by_id', referencedColumnName: 'id', nullable: false)]
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
