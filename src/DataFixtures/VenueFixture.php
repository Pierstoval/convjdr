<?php

namespace App\DataFixtures;

use App\Entity\Venue;
use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Orbitale\Component\ArrayFixture\ArrayFixture;

class VenueFixture extends ArrayFixture implements ORMFixtureInterface
{
    protected function getEntityClass(): string
    {
        return Venue::class;
    }

    protected function getReferencePrefix(): ?string
    {
        return 'venue-';
    }

    protected function getMethodNameForReference(): string
    {
        return 'getName';
    }

    protected function getObjects(): iterable
    {
        return [
            [
                'id' => 'ae58fc80-cf97-49b4-a7ec-6fba881dd1db',
                'name' => 'CPC',
                'address' => 'Puy',
            ],
        ];
    }
}
