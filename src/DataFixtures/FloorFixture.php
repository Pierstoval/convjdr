<?php

namespace App\DataFixtures;

use App\Entity\Floor;
use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Orbitale\Component\ArrayFixture\ArrayFixture;

class FloorFixture extends ArrayFixture implements ORMFixtureInterface, DependentFixtureInterface
{
    protected function getEntityClass(): string
    {
        return Floor::class;
    }

    protected function getReferencePrefix(): ?string
    {
        return 'floor-';
    }

    protected function getMethodNameForReference(): string
    {
        return 'getName';
    }

    public function getDependencies(): array
    {
        return [
            EventFixture::class,
        ];
    }

    protected function getObjects(): iterable
    {
        return [
            [
                'id' => '82038d5d-165e-44b3-9938-f286b6544298',
                'name' => 'RDC',
                'venue' => $this->getReference('venue-CPC'),
            ],
            [
                'id' => 'c97f718d-fd46-4d5d-80eb-7e52dee9b470',
                'name' => 'Entresol',
                'venue' => $this->getReference('venue-CPC'),
            ],
        ];
    }
}
