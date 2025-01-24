<?php

namespace App\Repository;

use App\Entity\Event;
use App\Entity\ScheduledAnimation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ScheduledAnimation>
 */
class ScheduledAnimationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ScheduledAnimation::class);
    }

    /**
     * @return array<ScheduledAnimation>
     */
    public function findForEvent(Event $event): array
    {
        return $this->createQueryBuilder('scheduled_animation')
            ->innerJoin('scheduled_animation.timeSlot', 'time_slot')
            ->innerJoin('time_slot.event', 'event')
            ->where('time_slot.event = :event')
            ->setParameter('event', $event)
            ->getQuery()
            ->getResult();
    }
}
