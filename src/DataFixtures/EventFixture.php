<?php

namespace App\DataFixtures;

use App\Entity\Event;
use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Orbitale\Component\ArrayFixture\ArrayFixture;

class EventFixture extends ArrayFixture implements ORMFixtureInterface, DependentFixtureInterface
{
    protected function getEntityClass(): string
    {
        return Event::class;
    }

    public function getDependencies(): array
    {
        return [
            UserFixture::class,
            VenueFixture::class,
        ];
    }

    protected function getObjects(): iterable
    {
        return [
            [
                'id' => 'b715276f-f7df-42ee-82f8-c21b05d2da2d',
                'name' => 'TDC 2025',
                'startsAt' => (new \DateTimeImmutable('today'))->setTime(0, 0, 0, 0),
                'endsAt' => (new \DateTimeImmutable('tomorrow'))->setTime(0, 0, 0, 0),
                'address' => 'CPC',
                'description' => 'Hello world',
                'creators' => new ArrayCollection([$this->getReference('user-admin')]),
                'enabled' => true,
            ],
        ];
    }
}
