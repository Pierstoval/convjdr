<?php

namespace App\Entity;

use App\Enum\ScheduleAnimationState;
use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event
{
    use Field\Id { Field\Id::__construct as private generateId; }
    use Field\Creators { Field\Creators::__construct as generateCreators; }
    use Field\Description;
    use Field\StartEndDates;
    use Field\Enabled;

    #[ORM\Column(name: 'name', type: Types::STRING, length: 255, nullable: false)]
    #[Assert\NotBlank(message: 'Please enter a name')]
    private ?string $name = '';

    #[ORM\Column(name: 'address', type: Types::TEXT, nullable: false)]
    private string $address = '';

    #[ORM\Column(name: 'is_online_event', type: Types::BOOLEAN, nullable: false)]
    #[Assert\Type('bool')]
    #[Assert\NotNull()]
    private bool $isOnlineEvent = false;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\Valid]
    private Venue $venue;

    public function __construct()
    {
        $this->generateId();
        $this->generateCreators();
    }

    public function __toString(): string
    {
        return $this->name ?: '';
    }

    public function getScheduledAnimationById(string $id): ScheduledAnimation
    {
        foreach ($this->getVenue()->getFloors() as $floor) {
            foreach ($floor->getRooms() as $room) {
                foreach ($room->getTables() as $table) {
                    foreach ($table->getTimeSlots() as $slot) {
                        foreach ($slot->getScheduledAnimations() as $scheduledAnimation) {
                            if ($scheduledAnimation->getId() === $id) {
                                return $scheduledAnimation;
                            }
                        }
                    }
                }
            }
        }

        throw new \RuntimeException(\sprintf('Could not find schedule "%s" in Event "%s".', $id, $this->name));
    }

    public function getTimeSlots(): array
    {
        $slots = [];

        foreach ($this->venue->getFloors() as $floor) {
            foreach ($floor->getRooms() as $room) {
                foreach ($room->getTimeSlots() as $slot) {
                    $slots[$slot->getId()] = $slot;
                }
            }
        }

        return \array_values($slots);
    }

    public function getCalendarResourceJson(): array
    {
        $json = [];

        foreach ($this->getVenue()->getFloors() as $floor) {
            $json[] = $floor->getCalendarResourceJson();
        }

        return $json;
    }

    /**
     * @param array<ScheduleAnimationState> $states
     * @return array
     */
    public function getCalendarSchedulesJson(array $states): array
    {
        $json = [];

        foreach ($this->getVenue()->getFloors() as $floor) {
            foreach ($floor->getRooms() as $room) {
                foreach ($room->getTables() as $table) {
                    foreach ($table->getTimeSlots() as $slot) {
                        $animations = $slot->getScheduledAnimations();
                        foreach ($animations as $scheduledAnimation) {
                            if (!\in_array($scheduledAnimation->getState(), $states)) {
                                continue;
                            }
                            $json[] = [
                                'id' => $scheduledAnimation->getId(),
                                'title' => $scheduledAnimation->getAnimation()?->getName(),
                                'start' => $slot->getStartsAt()->format('Y-m-d H:i:s'),
                                'end' => $slot->getEndsAt()->format('Y-m-d H:i:s'),
                                'resourceId' => $table->getId(),
                                'extendedProps' => [
                                    'type' => 'animation',
                                    'description' => $scheduledAnimation->getAnimation()?->getDescription(),
                                ],
                                'color' => $scheduledAnimation->getStateColor(),
                            ];
                        }
                        if (!$animations->count()) {
                            $json[] = [
                                'id' => $slot->getId(),
                                'title' => '',
                                'start' => $slot->getStartsAt()->format('Y-m-d H:i:s'),
                                'end' => $slot->getEndsAt()->format('Y-m-d H:i:s'),
                                'resourceId' => $table->getId(),
                                'extendedProps' => ['type' => 'empty_slot'],
                                'color' => '#000',
                            ];
                        }
                    }
                }
            }
        }

        return $json;
    }

    //

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name ?: '';
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): void
    {
        $this->address = $address ?: '';
    }

    public function isOnlineEvent(): bool
    {
        return $this->isOnlineEvent;
    }

    public function setIsOnlineEvent(bool $isOnlineEvent): void
    {
        $this->isOnlineEvent = $isOnlineEvent;
    }

    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): void
    {
        $this->enabled = $enabled;
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
