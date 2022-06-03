<?php

namespace App\DataFixtures;

use App\Entity\Professeur;
use App\Entity\Rp;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\Module;


class Prof extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 20; $i++) {
            $rp = new Rp();
            $rp->setNomComplet("RP" . $i);
            $rp->setRole("ROLE_RP");
            $rp->setEmail("mailRPp" . $i);
            $rp->setPassword("passer123");
            $manager->persist($rp);
            $module = new Module();
            $module->setLibelle('Module ' . $i);
            $manager->persist($module);
            $prof = new Professeur();
            $grade = ["MASTER", "INGENIEUR", "DOCTEUR"];
            $mod = ["MATH", "PC", "ALGO"];

            $pos = round(0, 2);
            $prof->setNomComplet('Prof' . $i);
            $prof->setRole("ROLE_PROFESSEUR");
            $prof->setGrade($grade[$pos]);

            // $prof->addModule($this->getReference($module[$pos]));
            $prof->addModule($module);
            $prof->setRp($rp);
            $manager->persist($prof);
            $this->addReference("Professeur" . $i, $prof);
        }

        $manager->flush();
    }
}
