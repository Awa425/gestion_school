<?php

namespace App\DataFixtures;

use App\Entity\Etudiant;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EtudiantFixture extends Fixture
{

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 5; $i++) {
            // $et = new Etudiant();
            // $et->setNomComplet('etudiant' . $i);
            // $et->setEmail('mail_etu' . $i);
            // $et->setPassword('passer123');
            // $et->setRoles(["ROLE_ETUDIANT"]);
            // $et->setSexe('F');
            // $et->setAdresse('Pikine');
            // $et->setMatricule("Mat" . $i);
            // $manager->persist($et);
            // $this->addReference("etudiant" . $i, $et);
        }
        $manager->flush();
    }
}
