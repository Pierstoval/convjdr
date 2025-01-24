<?php

namespace App\DataFixtures;

use App\Entity\Animation;
use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Orbitale\Component\ArrayFixture\ArrayFixture;

class AnimationFixture extends ArrayFixture implements ORMFixtureInterface, DependentFixtureInterface
{
    use GetObjectsFromData;

    public const DATA = [
        '7645788c-edde-4b51-9cb8-1c6f641ceffe' => [
            'name' => 'Animation de jeu',
            'description' => 'Lorem ipsum',
            'maxNumberOfParticipants' => 5,
            'creators' => ['ref/user-admin'],
        ],
        '173be12f-228a-4da2-8d4c-29d096ef7c0a' => [
            'name' => 'Visitor animation',
            'description' => 'Lorem ipsum',
            'maxNumberOfParticipants' => 5,
            'creators' => ['ref/user-visitor'],
        ],
    ];

    protected function getEntityClass(): string
    {
        return Animation::class;
    }

    protected function getReferencePrefix(): ?string
    {
        return 'animation-';
    }

    protected function getMethodNameForReference(): string
    {
        return 'getName';
    }

    public function getDependencies(): array
    {
        return [
            UserFixture::class,
        ];
    }
}
