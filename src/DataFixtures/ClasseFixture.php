<?php

namespace App\DataFixtures;

use App\Entity\Rp;
use App\Entity\Classe;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ClasseFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 20; $i++) {
            $rp = new Rp();
            $rp->setRoles(['ROLE_RP']);
            $rp->setNomComplet("Rp");
            $rp->setEmail("mjhail@gmail.com" . $i);
            $rp->setPassword("passer123");
            $manager->persist($rp);
            $classe = new Classe();
            $classe->setLibelle('WEB');
            $classe->setNiveau('L1');
            $classe->setFilliere('SRT' . $i);
            $classe->setRp($rp);
            $manager->persist($classe);
        }
        $manager->flush();
    }
}
