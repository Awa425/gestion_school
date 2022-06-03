<?php

namespace App\DataFixtures;

use App\Entity\Rp;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RpFixture extends Fixture
{
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
            $rp->setEmail("mailRPrp" . $i);
            $rp->setPassword("passer123");
            $manager->persist($rp);
            $this->addReference('Rp' . $i, $rp);
        }
        $manager->flush();
    }
}
