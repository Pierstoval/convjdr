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
                'startsAt' => (new \DateTimeImmutable('10 days'))->setTime(1, 0, 0, 0),
                'endsAt' => (new \DateTimeImmutable('10 days'))->setTime(2, 0, 0, 0),
                'table' => $this->getReference('table-Table face pôle JdR 1'),
                'event' => $this->getReference('event-TDC 2025'),
                'category' => $this->getReference('time-slot-category-Morning'),
            ],
            [
                'id' => '11cca5a1-57f5-408c-bb2d-27cd0631fc5c',
                'startsAt' => (new \DateTimeImmutable('10 days'))->setTime(2, 0, 0, 0),
                'endsAt' => (new \DateTimeImmutable('10 days'))->setTime(3, 0, 0, 0),
                'table' => $this->getReference('table-Table face pôle JdR 1'),
                'event' => $this->getReference('event-TDC 2025'),
                'category' => $this->getReference('time-slot-category-Morning'),
            ],
            [
                'id' => '4ae5a1ed-8c39-4c4e-9f0a-2b4169ecabf1',
                'startsAt' => (new \DateTimeImmutable('10 days'))->setTime(3, 0, 0, 0),
                'endsAt' => (new \DateTimeImmutable('10 days'))->setTime(4, 0, 0, 0),
                'table' => $this->getReference('table-Table face pôle JdR 1'),
                'event' => $this->getReference('event-TDC 2025'),
                'category' => $this->getReference('time-slot-category-Morning'),
            ],
            [
                'id' => '1d508edc-2963-4014-b822-32bb771d2245',
                'startsAt' => (new \DateTimeImmutable('10 days'))->setTime(4, 0, 0, 0),
                'endsAt' => (new \DateTimeImmutable('10 days'))->setTime(5, 0, 0, 0),
                'table' => $this->getReference('table-Table face pôle JdR 1'),
                'event' => $this->getReference('event-TDC 2025'),
                'category' => $this->getReference('time-slot-category-Morning'),
            ],
            [
                'id' => 'ed52861f-3cfd-47df-ac1d-ffaedf6910e8',
                'startsAt' => (new \DateTimeImmutable('10 days'))->setTime(6, 0, 0, 0),
                'endsAt' => (new \DateTimeImmutable('10 days'))->setTime(7, 0, 0, 0),
                'table' => $this->getReference('table-Table face pôle JdR 1'),
                'event' => $this->getReference('event-TDC 2025'),
                'category' => $this->getReference('time-slot-category-Evening'),
            ],
            [
                'id' => '29f08a4f-4c31-4735-9280-3eb103df1b9a',
                'startsAt' => (new \DateTimeImmutable('11 days'))->setTime(3, 0, 0, 0),
                'endsAt' => (new \DateTimeImmutable('11 days'))->setTime(7, 0, 0, 0),
                'table' => $this->getReference('table-Public'),
                'event' => $this->getReference('event-TDC 2025'),
                'category' => $this->getReference('time-slot-category-Morning'),
            ],
            [
                'id' => '58a6fd03-9767-4828-a068-eaed48545b92',
                'startsAt' => (new \DateTimeImmutable('11 days'))->setTime(7, 0, 0, 0),
                'endsAt' => (new \DateTimeImmutable('11 days'))->setTime(8, 0, 0, 0),
                'table' => $this->getReference('table-Table proto 1'),
                'event' => $this->getReference('event-TDC 2025'),
                'category' => $this->getReference('time-slot-category-Morning'),
            ],
        ];
    }
}
