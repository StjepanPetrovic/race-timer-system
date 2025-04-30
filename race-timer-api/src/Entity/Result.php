<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ApiResource]
class Result
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\ManyToOne(targetEntity: Race::class, inversedBy: "results")]
    private Race $race;

    #[ORM\ManyToOne(targetEntity: Runner::class)]
    private Runner $runner;

    #[ORM\Column(type: "datetime_immutable")]
    private \DateTimeImmutable $time;

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

    public function getTime(): \DateTimeImmutable
    {
        return $this->time;
    }

    public function setTime(\DateTimeImmutable $time): self
    {
        $this->time = $time;

        return $this;
    }
}