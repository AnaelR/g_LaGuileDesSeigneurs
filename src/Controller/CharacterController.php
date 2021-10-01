<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Character;

class CharacterController extends AbstractController
{
    /**
     * @Route("/character", name="character",
     * methods={"GET","HEAD"})
     */
    public function index(): Response
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/CharacterController.php',
        ]);
    }

    /**
     * @Route ("/character/display",
     * name="character_display"
     * methods={"GET","HEAD"})
     */
    public function display():JsonResponse
    {
        $character = new Character();
// dump($character);dd($character->toArray());
        return new JsonResponse($character->toArray());
    }
}
