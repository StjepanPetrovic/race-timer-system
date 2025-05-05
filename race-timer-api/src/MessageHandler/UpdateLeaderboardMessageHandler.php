<?php

namespace App\MessageHandler;

use App\Entity\Leaderboard;
use App\Message\UpdateLeaderboardMessage;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\Parameter;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class UpdateLeaderboardMessageHandler
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    public function __invoke(UpdateLeaderboardMessage $message): void
    {
        $race = $this->entityManager->getReference('App\Entity\Race', $message->getRaceId());
        $runner = $this->entityManager->getReference('App\Entity\Runner', $message->getRunnerId());

        // Calculate position based on finish time
        $position = $this->calculatePosition($message->getRaceId(), $message->getFinishTime());

        // Update existing leaderboard entry or create new one
        $leaderboard = $this->entityManager->getRepository(Leaderboard::class)
            ->findOneBy(['race' => $race, 'runner' => $runner]) ?? new Leaderboard();

        $leaderboard->setRace($race)
            ->setRunner($runner)
            ->setPosition($position)
            ->setFinishTime($message->getFinishTime())
            ->setUpdatedAt(new \DateTimeImmutable());

        $this->entityManager->persist($leaderboard);
        $this->entityManager->flush();

        // Recalculate positions for affected runners
        $this->recalculatePositions($message->getRaceId());
    }

    private function calculatePosition(int $raceId, \DateTimeImmutable $finishTime): int
    {
        $qb = $this->entityManager->createQueryBuilder();
        return $qb->select('COUNT(l.id) + 1')
            ->from(Leaderboard::class, 'l')
            ->where('l.race = :raceId')
            ->andWhere('l.finishTime < :finishTime')
            ->setParameters(new ArrayCollection([
                new Parameter('raceId', $raceId),
                new Parameter('finishTime', $finishTime)
            ]))
            ->getQuery()
            ->getSingleScalarResult();
    }

    private function recalculatePositions(int $raceId): void
    {
        $qb = $this->entityManager->createQueryBuilder();
        $leaderboards = $qb->select('l')
            ->from(Leaderboard::class, 'l')
            ->where('l.race = :raceId')
            ->orderBy('l.finishTime', 'ASC')
            ->setParameter('raceId', $raceId)
            ->getQuery()
            ->getResult();

        foreach ($leaderboards as $index => $leaderboard) {
            $leaderboard->setPosition($index + 1);
        }

        $this->entityManager->flush();
    }
}