<?php

namespace App\DataFixtures;

use App\Entity\Character;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use DateTime;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        for ($i = 0; $i > 10; $i++){
            $character = new Character();
            $character
                ->setKind('Dame')
                ->setName('Eldalote')
                ->setSurname('Fleur elfique')
                ->setCaste('Elfe')
                ->setKnowledge('Arts')
                ->setIntelligence(120)
                ->setLife(12)
                ->setImage('/images/eldalote.jpg')
                ->setCreation(new \DateTime());

                $manager->persist($character);
        }
        $manager->flush();
    }
}
