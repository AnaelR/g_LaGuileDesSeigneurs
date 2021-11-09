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

    public function __construct(CharacterServiceInterface $characterService)
    {
        $this->characterService = $characterService;
    }
    /**
     * @Route("/character/index", name="character_index",
     * methods={"GET","HEAD"})
     */
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('characterIndex', null);
        $character = $this->characterService->getAll();
        return new JsonResponse($character);
        // return $this->json([
        //     'message' => 'Welcome to your new controller!',
        //     'path' => 'src/Controller/CharacterController.php',
        // ]);
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

    /**
     * @Route("/character",
     * name="character_redirect_index",
     * methods={"GET", "HEAD"}
     * )
     */
    public function redirectIndex()
    {
        return $this->redirectToRoute('character_index');
    }

    //MODIFY
    /**
     * @Route ("/character/modify/{identifier}",
     * name="character_modify",
     * requirements={"identifier": "^([a-z0-9]{40})$"},
     * methods={"PUT", "HEAD"}
     * )
     */
    public function modify(Character $character)
    {
        $this->denyAccessUnlessGranted('characterModify', $character);
        $character = $this->characterService->modify($character);
        return new JsonResponse($character->toArray());
    }


    //DELTE
    /**
     * @Route ("/character/delete/{identifier}",
     * name="character_delete",
     * requirements={"identifier": "^([a-z0-9]{40})$"},
     * methods={"DELETE", "HEAD"}
     * )
     */
    public function delete(Character $character)
    {
        $this->denyAccessUnlessGranted('characterDelete', $character);
        $response = $this->characterService->delete($character);
        return new JsonResponse(array('delete' => $response));
    }

    //IMAGES
    /**
     * Returns images randomly
     * 
     * @Route("/character/images/{number}",
     * name="character_images",
     * requirements={"identifier": "^([0-9]{1,2})$"},
     * methods={"GET", "HEAD"}
     * )
     */

    public function images(int $number, ?string $kind = null)
    {
        $this->denyAccessUnlessGranted('characterIndex', null);
        $images = $this->characterService->getImages($number);
        return new JsonResponse($images);
    }

    /**
     * Returns images of specific kind
     * 
     * @Route("/character/images/{kind}/{number}",
     * name="character_imagesKind",
     * requirements={"identifier": "^([a-z0-9]{40})$"},
     * methods={"GET", "HEAD"}
     * )
     */

    public function imagesKind(int $number, string $kind)
    {
        $this->denyAccessUnlessGranted('characterIndex', null);
        $imagesKind = $this->characterService->getImages($number, $kind);
        return new JsonResponse($imagesKind);
    }
}
