<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Service\CharacterServiceInterface;
use App\Entity\Character;

class CharacterController extends AbstractController
{

    private $characterService;

    public function __construct(CharacterServiceInterface $characterService){
        $this->characterService = $characterService;
    }
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
     * @Route ("/character/display/{identifier}",
     * name="character_display",
     * requirements={"identifier": "^([a-z0-9]{40})$"},
     * methods={"GET","HEAD"})
     */
    public function display(Character $character): JsonResponse
    {
        // dump($character);dd($character->toArray());
        $this->denyAccessUnlessGranted('characterDisplay', $character);
        return new JsonResponse($character->toArray());
    }

    //CREATE
    /**
     * @Route("/character/create",
     * name="character_create",
     * methods={"POST", "HEAD"})
     */

    public function create()
    {
        $this->denyAccessUnlessGranted('characterCreate');
        $character = $this->characterService->create();
        return new JsonResponse($character->toArray());
    }
}
