<?php

namespace App\DataFixtures;

use Faker\Factory;
use Faker\Generator;
use App\Entity\Classe;


use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;


class AppFixtures extends Fixture
{
    private Generator $faker;

    public function __construct(){
        $this->faker=Factory::Create("fr_Fr");
    }

    public function load(ObjectManager $manager): void
    {
        // for ($i=1; $i <= 5 ; $i+1) { 
        //     $classe=new Classe();
        //     $classe->setNiveau($this->faker->word());
        //     $manager->persist($classe);
        // }

        $manager->flush();
    }
}
