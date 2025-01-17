<?php

namespace App\DataFixtures;

use App\Entity\Animation;
use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Orbitale\Component\ArrayFixture\ArrayFixture;

class AnimationFixture extends ArrayFixture implements ORMFixtureInterface, DependentFixtureInterface
{
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

    protected function getObjects(): iterable
    {
        return [
            [
                'id' => '7645788c-edde-4b51-9cb8-1c6f641ceffe',
                'name' => 'Animation de jeu',
                'description' => 'Lorem ipsum',
                'maxNumberOfParticipants' => 5,
                'creators' => new ArrayCollection([$this->getReference('user-admin')]),
            ],
        ];
    }
}
