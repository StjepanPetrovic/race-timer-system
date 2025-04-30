<?php

namespace App\DataFixtures;

use App\Entity\Race;
use App\Entity\Runner;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RaceFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 3; $i++) {
            $race = new Race();
            $race->setName("Race $i");
            $race->setDate(new \DateTimeImmutable("+$i days"));
            $race->setLocation("Location $i");

            $manager->persist($race);

            // Create some runners for each race.
            for ($j = 1; $j <= 5; $j++) {
                $runner = new Runner();
                $runner->setName("Runner $j");
                $runner->setSurname("Surname $j");
                $runner->setStartNumber($i * 10 + $j);

                $manager->persist($runner);
            }
        }


        $manager->flush();
    }
}
