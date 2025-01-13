<?php

namespace App\Entity;

use App\Enum\ScheduleAnimationState;
use App\Repository\ScheduledAnimationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ScheduledAnimationRepository::class)]
class ScheduledAnimation
{
    use Field\Id;

    #[ORM\Column(length: 255)]
    private ScheduleAnimationState $state = ScheduleAnimationState::CREATED;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Animation $animation = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Table $animationTable = null;

    #[ORM\ManyToOne()]
    #[ORM\JoinColumn(nullable: false)]
    private ?TimeSlot $slot = null;

    public function getState(): ScheduleAnimationState
    {
        return $this->state;
    }

    public function setState(ScheduleAnimationState $state): void
    {
        $this->state = $state;
    }

    public function getAnimation(): ?Animation
    {
        return $this->animation;
    }

    public function setAnimation(?Animation $animation): void
    {
        $this->animation = $animation;
    }

    public function getAnimationTable(): ?Table
    {
        return $this->animationTable;
    }

    public function setAnimationTable(?Table $animationTable): void
    {
        $this->animationTable = $animationTable;
    }

    public function getSlot(): ?TimeSlot
    {
        return $this->slot;
    }

    public function setSlot(?TimeSlot $slot): void
    {
        $this->slot = $slot;
    }
}
