<?php

namespace App\DataFixtures;

use App\Entity\Ac;
use App\Entity\Rp;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AcFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 20; $i++) {

            $rp = new Rp();
            $rp->setNomComplet("RP" . $i);
            $rp->setRole("ROLE_RP");
            $rp->setEmail("mailRPac" . $i);
            $rp->setPassword("passer123");
            $manager->persist($rp);
            $ac = new Ac();
            $ac->setNomComplet('ac' . $i);
            $ac->setEmail('ac' . $i . '@gmail.com');
            $ac->setPassword('passer123');
            $ac->setRole('ROLE_AC');
            $ac->setRp($rp);
            $manager->persist($ac);
        }

        $manager->flush();
    }
}
