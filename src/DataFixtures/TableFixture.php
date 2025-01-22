<?php

namespace App\DataFixtures;

use App\Entity\Table;
use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Orbitale\Component\ArrayFixture\ArrayFixture;

class TableFixture extends ArrayFixture implements ORMFixtureInterface, DependentFixtureInterface
{
    use GetObjectsFromData;

    public const array DATA = [
        '53f0c904-34a0-4b1b-8e73-3bd2bfcd3dfa' => [
            'name' => 'Table face pôle JdR 1',
            'maxNumberOfParticipants' => 5,
            'room' => 'ref/room-Hall principal',
        ],
        'd6d12434-cff2-4b65-be7d-48b525a89839' => [
            'name' => 'Table face pôle JdR 2',
            'maxNumberOfParticipants' => 5,
            'room' => 'ref/room-Hall principal',
        ],
        'fed1fa05-728e-403c-8c2f-a3e01c1cd14a' => [
            'name' => 'Table proto 1',
            'maxNumberOfParticipants' => 4,
            'room' => 'ref/room-Salle entresol',
        ],
        '6ec3dd38-f4ed-425c-94a1-cb64dc16cfcb' => [
            'name' => 'Table proto 2',
            'maxNumberOfParticipants' => 4,
            'room' => 'ref/room-Salle entresol',
        ],
        '9f4ece41-25be-4164-9dab-01ad16fd5e73' => [
            'name' => 'Sièges public',
            'maxNumberOfParticipants' => 280,
            'room' => 'ref/room-Scène',
        ],
        'ef3b8529-29ec-41e2-8c85-a06fe4f2bd12' => [
            'name' => 'Participants scène',
            'maxNumberOfParticipants' => null,
            'room' => 'ref/room-Scène',
        ],
    ];

    protected function getEntityClass(): string
    {
        return Table::class;
    }

    protected function getReferencePrefix(): ?string
    {
        return 'table-';
    }

    protected function getMethodNameForReference(): string
    {
        return 'getName';
    }

    public function getDependencies(): array
    {
        return [
            RoomFixture::class,
        ];
    }
}
