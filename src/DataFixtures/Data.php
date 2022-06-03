<?php

namespace App\DataFixtures;

use App\Entity\Rp;
use App\Entity\User;
use App\Entity\Classe;
use App\Entity\AnneeScolaire;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class Data extends Fixture
{
    public function load(ObjectManager $manager): void
    {


        for ($i = 2016; $i < 2022; $i++) {
            $an = new AnneeScolaire();
            $annee = $i . "-" . ($i + 1);
            $an->setLibelle($annee)
                ->setEtat(false);
            $manager->persist($an);
            $this->addReference('annee' . $i, $an);
        }
        $manager->flush();
    }
}
