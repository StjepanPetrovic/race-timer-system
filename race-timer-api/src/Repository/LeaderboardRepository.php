<?php

namespace App\Repository;

use App\Entity\Leaderboard;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class LeaderboardRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Leaderboard::class);
    }

    public function getLeaderboardByRace(int $raceId, int $limit = 10): array
    {
        return $this->createQueryBuilder('l')
            ->where('l.race = :raceId')
            ->orderBy('l.position', 'ASC')
            ->setParameter('raceId', $raceId)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }
}