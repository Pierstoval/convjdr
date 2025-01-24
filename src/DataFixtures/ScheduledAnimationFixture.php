<?php

namespace App\DataFixtures;

use App\Entity\ScheduledAnimation;
use App\Enum\ScheduleAnimationState;
use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Orbitale\Component\ArrayFixture\ArrayFixture;

class ScheduledAnimationFixture extends ArrayFixture implements ORMFixtureInterface, DependentFixtureInterface
{
    use GetObjectsFromData;

    public const DATA = [
        '94d9b83c-c14e-42ae-8b64-af02e1cda3d6' => [
            'animation' => 'ref/animation-Animation de jeu',
            'timeSlot' => 'ref/timeslot-28b98eb2-4fef-4587-9749-25af666c25e0',
            'state' => ScheduleAnimationState::CREATED,
        ],
        '957281d4-b8b2-4fe7-bc92-1d58dd33b89f' => [
            'animation' => 'ref/animation-Animation de jeu',
            'timeSlot' => 'ref/timeslot-11cca5a1-57f5-408c-bb2d-27cd0631fc5c',
            'state' => ScheduleAnimationState::PENDING_REVIEW,
        ],
        '84de7975-7669-4be3-be03-30133dd4e722' => [
            'animation' => 'ref/animation-Visitor animation',
            'timeSlot' => 'ref/timeslot-4ae5a1ed-8c39-4c4e-9f0a-2b4169ecabf1',
            'state' => ScheduleAnimationState::REFUSED,
        ],
        '8a779e2e-9f73-4ecb-bc9b-e63e96555965' => [
            'animation' => 'ref/animation-Visitor animation',
            'timeSlot' => 'ref/timeslot-1d508edc-2963-4014-b822-32bb771d2245',
            'state' => ScheduleAnimationState::ACCEPTED,
        ],
    ];

    protected function getEntityClass(): string
    {
        return ScheduledAnimation::class;
    }

    protected function getReferencePrefix(): ?string
    {
        return 'scheduled-animation-';
    }

    public function getDependencies(): array
    {
        return [
            AnimationFixture::class,
            TimeSlotFixture::class,
        ];
    }
}
