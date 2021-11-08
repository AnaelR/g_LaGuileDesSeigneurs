<?php

namespace App\Service;

use DateTime;
use App\Entity\Player;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PlayerRepository;

class PlayerService implements PlayerServiceInterface
{


    private $em;

    private $playerRepository;

    public function __construct(PlayerRepository $playerRepository, EntityManagerInterface $em)
    {
        $this->playerRepository = $playerRepository;
        $this->em = $em;
    }
    /**
     * {@inheritdoc}
     */
    public function create()
    {
        $player = new Player();
        $player
            ->setFirstname('Romain')
            ->setLastname('Echalote')
            ->setEmail('tutu@tata.com')
            ->setMirian(20)
            ->setPseudo('Kaunardo')
            ->setCreation(new \DateTime())
            ->setIdentifier(hash('sha1', uniqid()))
            ->setModification(new \DateTime());

        $this->em->persist($player);
        $this->em->flush();
        return $player;
    }

    /**
     * {@inheritdoc}
     */
    public function modify(Player $player)
    {
        $player
            ->setFirstname('Romain')
            ->setLastname('Echalote')
            ->setEmail('tutu@tata.com')
            ->setMirian(20)
            ->setPseudo('Kaunardo')
            ->setModification(new \DateTime());
        $this->em->persist($player);
        $this->em->flush();
        return $player;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(Player $player)
    {
        $this->em->remove($player);
        $this->em->flush();

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function getAll()
    {
        $playersFinal = array();
        $players = $this->playerRepository->findAll();
        foreach ($players as $player) {
            $playersFinal[] = $player->toArray();
        }
        return $playersFinal;
    }
}
