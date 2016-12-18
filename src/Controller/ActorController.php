<?php

namespace App\Controller;

use App\Entity\Meselus\Actor;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class ActorController.
 *
 * @Route("/actor", name="actor_")
 */
class ActorController extends AbstractController
{
    /**
     * @Route("s/", name="list")
     */
    public function listAction(SerializerInterface $serializer): JsonResponse
    {
        $actorRepository = $this->getDoctrine()->getRepository(Actor::class);

        $actors = $actorRepository->findAll();

        return new JsonResponse(
            $serializer->serialize($actors, 'json'),
            JsonResponse::HTTP_OK,
            [],
            true
        );
    }

    /**
     * @Route("/{id}", name="show")
     */
    public function showAction(Actor $actor, SerializerInterface $serializer): JsonResponse
    {
        return new JsonResponse(
            $serializer->serialize($actor, 'json'),
            JsonResponse::HTTP_OK,
            [],
            true
        );
    }
}
