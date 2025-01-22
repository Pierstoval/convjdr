<?php

namespace App\DataFixtures;

use App\Entity\Room;
use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Orbitale\Component\ArrayFixture\ArrayFixture;

class RoomFixture extends ArrayFixture implements ORMFixtureInterface, DependentFixtureInterface
{
    use GetObjectsFromData;

    public const DATA = [
        '7645788c-edde-4b51-9cb8-1c6f641ceffe' => [
            'name' => 'Hall principal',
            'floor' => 'ref/floor-RDC',
        ],
        '69d2d1b9-622e-4bb7-b3e7-7bd613b48fac' => [
            'name' => 'Hall jeux',
            'floor' => 'ref/floor-RDC',
        ],
        '33eeb3c9-d1ea-4a12-b8de-3f91ae3af16f' => [
            'name' => 'Salle musique',
            'floor' => 'ref/floor-RDC',
        ],
        'b305a315-da12-400d-bbb7-b3376b37e05e' => [
            'name' => 'Salle entresol',
            'floor' => 'ref/floor-Entresol',
        ],
        'a255036d-6bcf-4032-af64-be31d1cee7e0' => [
            'name' => 'Scène',
            'floor' => 'ref/floor-Entresol',
        ],
    ];

    protected function getEntityClass(): string
    {
        return Room::class;
    }

    protected function getReferencePrefix(): ?string
    {
        return 'room-';
    }

    protected function getMethodNameForReference(): string
    {
        return 'getName';
    }

    public function getDependencies(): array
    {
        return [
            FloorFixture::class,
        ];
    }
}
