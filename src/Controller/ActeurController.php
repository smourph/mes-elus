<?php

namespace App\Controller;

use App\Entity\Datagouv\Acteur\Acteur;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class ActeurController.
 *
 * @Route("/acteur", name="acteur_")
 */
class ActeurController extends AbstractController
{
    /**
     * @Route("s/", name="list")
     */
    public function listAction(SerializerInterface $serializer): JsonResponse
    {
        $acteurRepository = $this->getDoctrine()->getRepository(Acteur::class);

        $acteurs = $acteurRepository->findAll();

        return new JsonResponse(
            $serializer->serialize($acteurs, 'json'),
            JsonResponse::HTTP_OK,
            [],
            true
        );
    }

    /**
     * @Route("/{uid}", name="show")
     */
    public function showAction(Acteur $acteur, SerializerInterface $serializer): JsonResponse
    {
        return new JsonResponse(
            $serializer->serialize($acteur, 'json'),
            JsonResponse::HTTP_OK,
            [],
            true
        );
    }
}
