<?php

namespace App\Repository;

use App\Entity\Event;
use App\Entity\TimeSlot;
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
        $result = $this->createQueryBuilder('time_slot')
            ->select('count(time_slot) as has_overlaps')
            ->where('time_slot.event = :event')
            ->andWhere('time_slot.startsAt < :end')
            ->andWhere('time_slot.endsAt > :start')
            ->setParameter('start', $value->getStartsAt())
            ->setParameter('end', $value->getEndsAt())
            ->setParameter('event', $value->getEvent())
            ->getQuery()
            ->getSingleScalarResult();

        return $result > 0;
    }

    /**
     * @return array<TimeSlot>
     */
    public function findForEvent(Event $event): array
    {
        return $this->createQueryBuilder('time_slot')
            ->where('time_slot.event = :event')
            ->setParameter('event', $event)
            ->getQuery()
            ->getResult()
        ;
    }
}
