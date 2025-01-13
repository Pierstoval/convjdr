<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event
{
    use Field\Id { Field\Id::__construct as generateId; }
    use Field\Creators { Field\Creators::__construct as generateCreators; }
    use Field\Name;
    use Field\Description;
    use Field\StartEndDates;

    #[ORM\Column(type: Types::TEXT, nullable: false)]
    private string $address = '';

    #[ORM\Column(nullable: false)]
    private bool $isOnlineEvent = false;

    #[ORM\Column(nullable: false)]
    private bool $enabled = false;

    #[ORM\ManyToOne]
    private Venue $venue;

    public function __construct()
    {
        $this->generateId();
        $this->generateCreators();
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
