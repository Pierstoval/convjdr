<?php

namespace App\DataFixtures;

use App\Entity\Table;
use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Orbitale\Component\ArrayFixture\ArrayFixture;

class TableFixture extends ArrayFixture implements ORMFixtureInterface, DependentFixtureInterface
{
    protected function getEntityClass(): string
    {
        return Table::class;
    }

    public function getDependencies(): array
    {
        return [
            RoomFixture::class,
        ];
    }

    protected function getObjects(): iterable
    {
        return [
            [
                'id' => '53f0c904-34a0-4b1b-8e73-3bd2bfcd3dfa',
                'name' => 'Table face pôle JdR 1',
                'maxNumberOfParticipants' => 5,
                'room' => $this->getReference('room-Hall principal'),
            ],
            [
                'id' => 'd6d12434-cff2-4b65-be7d-48b525a89839',
                'name' => 'Table face pôle JdR 2',
                'maxNumberOfParticipants' => 5,
                'room' => $this->getReference('room-Hall principal'),
            ],
            [
                'id' => 'fed1fa05-728e-403c-8c2f-a3e01c1cd14a',
                'name' => 'Table proto 1',
                'maxNumberOfParticipants' => 4,
                'room' => $this->getReference('room-Salle entresol'),
            ],
            [
                'id' => '6ec3dd38-f4ed-425c-94a1-cb64dc16cfcb',
                'name' => 'Table proto 2',
                'maxNumberOfParticipants' => 4,
                'room' => $this->getReference('room-Salle entresol'),
            ],
            [
                'id' => '9f4ece41-25be-4164-9dab-01ad16fd5e73',
                'name' => 'Scène',
                'maxNumberOfParticipants' => 280,
                'room' => $this->getReference('room-Scène'),
            ],
        ];
    }
}
