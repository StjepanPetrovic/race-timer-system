<?php

namespace App\Service;

use App\Entity\Result;
use App\Message\UpdateLeaderboardMessage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class ResultService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private MessageBusInterface $messageBus
    ) {
    }

    public function saveResult(Result $result): void
    {
        // Save the result
        $this->entityManager->persist($result);
        $this->entityManager->flush();

        // Dispatch message to update leaderboard
        $this->messageBus->dispatch(new UpdateLeaderboardMessage(
            $result->getRace()->getId(),
            $result->getRunner()->getId(),
            $result->getTime()
        ));
    }
}