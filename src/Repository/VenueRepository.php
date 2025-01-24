<?php

namespace App\Repository;

use App\Entity\Venue;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Venue>
 */
class VenueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Venue::class);
    }

    public function findWithRelations(string $id): Venue
    {
        return $this->createQueryBuilder('venue')
            ->where('venue.id = :id')
                ->setParameter('id', $id)
            ->innerJoin('venue.floors', 'floor')
                ->addSelect('floor')
            ->innerJoin('floor.rooms', 'room')
                ->addSelect('room')
            ->innerJoin('room.tables', 'table')
                ->addSelect('table')
            ->getQuery()
            ->getSingleResult()
        ;
    }
}
