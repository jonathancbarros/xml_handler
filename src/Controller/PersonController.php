<?php

namespace App\Controller;

use App\Classes\CustomNormalizer;
use App\Entity\Person;
use App\Repository\PersonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer;

/**
 * @Route("/people")
 */
class PersonController extends Controller
{
    /**
     * @Route("/", name="people_index", methods="GET")
     * @param PersonRepository $personRepository
     * @return Response
     */
    public function index(PersonRepository $personRepository): Response
    {
        $serializer = new Serializer([new CustomNormalizer()], [new JsonEncoder()]);
        $jsonContent = $serializer->serialize($personRepository->findAll(), 'json');

        $response = new Response($jsonContent);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("/{personId}", name="people_show", methods="GET")
     * @param $personId
     * @return Response
     */
    public function show($personId): Response
    {
        $person = $this->getDoctrine()
            ->getRepository(Person::class)
            ->findOneBy(['personId' => $personId]);

        if (!$person) {
            return new Response("Person Not Found", 404);
        }

        $serializer = new Serializer([new CustomNormalizer()], [new JsonEncoder()]);
        $jsonContent = $serializer->serialize($person, 'json');

        $response = new Response($jsonContent);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
