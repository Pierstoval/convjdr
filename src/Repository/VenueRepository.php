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
        return $this->getEntityManager()->createQuery(<<<DQL
            SELECT
                venue,
                floor,
                room,
                table
            FROM {$this->getEntityName()} venue
            INNER JOIN venue.floors floor
            INNER JOIN floor.rooms room
            INNER JOIN room.tables table
            WHERE venue.id = :id
        DQL
        )
            ->setParameter('id', $id)
            ->getSingleResult();
    }
}
