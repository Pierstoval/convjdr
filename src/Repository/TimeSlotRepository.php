<?php

namespace App\Repository;

use App\Entity\Event;
use App\Entity\TimeSlot;
use App\Enum\ScheduleAnimationState;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TimeSlot>
 */
class TimeSlotRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TimeSlot::class);
    }

    public function hasOverlap(TimeSlot $value): bool
    {
        $result = $this->getEntityManager()->createQuery(<<<DQL
            SELECT count(time_slot) as has_overlaps
            FROM {$this->getEntityName()} time_slot
            WHERE time_slot.event = :event
                AND time_slot.startsAt < :end
                AND time_slot.endsAt > :start
        DQL
        )
            ->setParameter('start', $value->getStartsAt())
            ->setParameter('end', $value->getEndsAt())
            ->setParameter('event', $value->getEvent())
            ->getSingleScalarResult();

        return $result > 0;
    }

    /**
     * @param array<ScheduleAnimationState> $states
     *
     * @return array<TimeSlot>
     */
    public function findForEvent(Event $event, array $states): array
    {
        return $this->getEntityManager()->createQuery(<<<DQL
            SELECT
                time_slot,
                event,
                table,
                scheduled_animations
            FROM {$this->getEntityName()} time_slot
            INNER JOIN time_slot.event event
            LEFT JOIN time_slot.table table
            LEFT JOIN time_slot.scheduledAnimations scheduled_animations
            WHERE time_slot.event = :event
            AND scheduled_animations.state IN (:states)
        DQL
        )
            ->setParameter('event', $event)
            ->setParameter('states', $states)
            ->getResult();
    }
}
