<?php

namespace App\Repository;

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

//    /**
//     * @return TimeSlot[] Returns an array of TimeSlot objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?TimeSlot
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
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
}
