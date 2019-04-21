<?php

namespace App\DataFixtures;

use App\Entity\Team;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class TeamFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $teams = [
            "Chaos Computer Club",
            "Computer Measurement Group (CMG)",
            "ComputerTown UK",
            "Homebrew Computer Club",
            "Port7Alliance",
            "Java User Group",
            "Perl Mongers",
            "Z User Group",
            "Linux Australia",
            "Linux Users of Victoria",
            "LinuxChix",
            "Loco team",
            "NYLUG",
            "Portland Linux/Unix",
            "RLUG",
            "SEUL",
        ];
        foreach ($teams as $team) {
            $group = new Team();
            $group->setName($team);

            $manager->persist($group);
        }
        $manager->flush();
    }
}
