<?php

namespace App\DataFixtures;

use App\Entity\Character;
use App\Entity\Player;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use DateTime;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        for ($i=0; $i < 10; $i++) {
            $character = new Character();
            $character
                ->setKind(rand(0, 1) ? 'Dame' : 'Seigneur')
                ->setName('Eldaloté' . $i)
                ->setSurname('Fleur elfique')
                ->setCaste('Elfe')
                ->setKnowledge('Arts')
                ->setIntelligence(mt_rand(100, 200))
                ->setLife(mt_rand(10, 20))
                ->setImage('/images/eldalote.jpg')
                ->setCreation(new DateTime())
                ->setIdentifier(hash('sha1', uniqid()))
                ->setModification(new DateTime())
            ;
            $manager->persist($character);
        }

        for ($i=0; $i < 10; $i++) {
            $player = new Player();
            $player
                ->setFirstname('Léo')
                ->setLastname('Dubois')
                ->setEmail('duboisl@gmail.com')
                ->setMirian(280)
                ->setPseudo('Leo_Knight')
                ->setCreation(new DateTime())
                ->setModification(new DateTime())
                ->setIdentifier(hash('sha1', uniqid()))
            ;
            $manager->persist($player);
        }
        $manager->flush();
    }
}
