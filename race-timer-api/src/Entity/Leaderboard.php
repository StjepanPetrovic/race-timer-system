<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ApiResource]
class Leaderboard
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\ManyToOne(targetEntity: Race::class)]
    private Race $race;

    #[ORM\ManyToOne(targetEntity: Runner::class)]
    private Runner $runner;

    #[ORM\Column(type: "integer")]
    private int $position;

    #[ORM\Column(type: "datetime_immutable")]
    private \DateTimeImmutable $finishTime;

    #[ORM\Column(type: "datetime_immutable")]
    private \DateTimeImmutable $updatedAt;

    public function getId(): int
    {
        return $this->id;
    }

    public function getRace(): Race
    {
        return $this->race;
    }

    public function setRace(Race $race): self
    {
        $this->race = $race;
        return $this;
    }

    public function getRunner(): Runner
    {
        return $this->runner;
    }

    public function setRunner(Runner $runner): self
    {
        $this->runner = $runner;
        return $this;
    }

    public function getPosition(): int
    {
        return $this->position;
    }

    public function setPosition(int $position): self
    {
        $this->position = $position;
        return $this;
    }

    public function getFinishTime(): \DateTimeImmutable
    {
        return $this->finishTime;
    }

    public function setFinishTime(\DateTimeImmutable $finishTime): self
    {
        $this->finishTime = $finishTime;
        return $this;
    }

    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }
}