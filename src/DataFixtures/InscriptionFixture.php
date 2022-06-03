<?php

namespace App\DataFixtures;

use App\Entity\Ac;
use App\Entity\Rp;
use App\Entity\Etudiant;
use App\Entity\Inscription;
use App\Entity\AnneeScolaire;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class InscriptionFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 20; $i++) {
            $rp = new Rp();
            $rp->setNomComplet("RP" . $i);
            $rp->setRole("ROLE_RP");
            $rp->setEmail("mailRPins" . $i);
            $rp->setPassword("passer123");
            $manager->persist($rp);
            $et = new Etudiant();
            $et->setNomComplet('etudiant' . $i);
            $et->setEmail('mail_etud' . $i);
            $et->setPassword('passer123');
            $et->setRoles(["ROLE_ETUDIANT"]);
            $et->setSexe('F');
            $et->setAdresse('Pikine');
            $et->setMatricule("Mat" . $i);
            $manager->persist($et);
            $an = new AnneeScolaire();
            $annee = $i . "-" . ($i + 1);
            $an->setLibelle($annee)
                ->setEtat(false);
            $manager->persist($an);
            $ac = new Ac();
            $ac->setNomComplet('ac' . $i);
            $ac->setEmail('ac @gmail.com' . $i);
            $ac->setPassword('passer123');
            $ac->setRole('ROLE_AC');
            $ac->setRp($rp);
            $manager->persist($ac);
            $ins = new Inscription();
            $ins->setAnneescolaireId($an);
            $ins->setEtudiant($et);
            $ins->setAc($ac);
            $manager->persist($ins);
        }

        $manager->flush();
    }
}
