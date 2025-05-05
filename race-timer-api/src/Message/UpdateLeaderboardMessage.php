<?php

namespace App\Message;

class UpdateLeaderboardMessage
{
    public function __construct(
        private int $raceId,
        private int $runnerId,
        private \DateTimeImmutable $finishTime
    ) {
    }

    public function getRaceId(): int
    {
        return $this->raceId;
    }

    public function getRunnerId(): int
    {
        return $this->runnerId;
    }

    public function getFinishTime(): \DateTimeImmutable
    {
        return $this->finishTime;
    }
}