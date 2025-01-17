<?php

namespace App\DataFixtures;

use App\Entity\TimeSlot;
use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Orbitale\Component\ArrayFixture\ArrayFixture;

class TimeSlotFixture extends ArrayFixture implements ORMFixtureInterface, DependentFixtureInterface
{
    protected function getEntityClass(): string
    {
        return TimeSlot::class;
    }

    protected function getReferencePrefix(): ?string
    {
        return 'timeslot-';
    }

    public function getDependencies(): array
    {
        return [
            EventFixture::class,
            FloorFixture::class,
            RoomFixture::class,
            TableFixture::class,
        ];
    }

    protected function getObjects(): iterable
    {
        return [
            [
                'id' => '28b98eb2-4fef-4587-9749-25af666c25e0',
                'startsAt' => (new \DateTimeImmutable('today'))->setTime(1, 0, 0, 0),
                'endsAt' => (new \DateTimeImmutable('tomorrow'))->setTime(2, 0, 0, 0),
                'table' => $this->getReference('table-Table face pôle JdR 1'),
                'event' => $this->getReference('event-TDC 2025'),
                'category' => $this->getReference('time-slot-category-Morning'),
            ],
            [
                'id' => '11cca5a1-57f5-408c-bb2d-27cd0631fc5c',
                'startsAt' => (new \DateTimeImmutable('today'))->setTime(2, 0, 0, 0),
                'endsAt' => (new \DateTimeImmutable('tomorrow'))->setTime(3, 0, 0, 0),
                'table' => $this->getReference('table-Table face pôle JdR 1'),
                'event' => $this->getReference('event-TDC 2025'),
                'category' => $this->getReference('time-slot-category-Morning'),
            ],
            [
                'id' => '4ae5a1ed-8c39-4c4e-9f0a-2b4169ecabf1',
                'startsAt' => (new \DateTimeImmutable('today'))->setTime(3, 0, 0, 0),
                'endsAt' => (new \DateTimeImmutable('tomorrow'))->setTime(4, 0, 0, 0),
                'table' => $this->getReference('table-Table face pôle JdR 1'),
                'event' => $this->getReference('event-TDC 2025'),
                'category' => $this->getReference('time-slot-category-Morning'),
            ],
            [
                'id' => '1d508edc-2963-4014-b822-32bb771d2245',
                'startsAt' => (new \DateTimeImmutable('today'))->setTime(4, 0, 0, 0),
                'endsAt' => (new \DateTimeImmutable('tomorrow'))->setTime(5, 0, 0, 0),
                'table' => $this->getReference('table-Table face pôle JdR 1'),
                'event' => $this->getReference('event-TDC 2025'),
                'category' => $this->getReference('time-slot-category-Morning'),
            ],
        ];
    }
}
