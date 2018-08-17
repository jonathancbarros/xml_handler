<?php

namespace App\Controller;

use App\Classes\CustomNormalizer;
use App\Entity\ShipOrder;
use App\Repository\ShipOrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer;

/**
 * @Route("/orders")
 */
class ShipOrderController extends Controller
{
    /**
     * @Route("/", name="ship_order_index", methods="GET")
     * @param ShipOrderRepository $shipOrderRepository
     * @return Response
     */
    public function index(ShipOrderRepository $shipOrderRepository)
    {
        $serializer = new Serializer([new CustomNormalizer()], [new JsonEncoder()]);
        $jsonContent = $serializer->serialize($shipOrderRepository->findAll(), 'json');

        $response = new Response($jsonContent);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("/{orderId}", name="ship_order_show", methods="GET")
     * @param $orderId
     * @return Response
     */
    public function show($orderId): Response
    {
        $order = $this->getDoctrine()
            ->getRepository(ShipOrder::class)
            ->findOneBy(['orderId' => $orderId]);

        if (!$order) {
            return new Response("Order Not Found", 404);
        }

        $serializer = new Serializer([new CustomNormalizer()], [new JsonEncoder()]);
        $jsonContent = $serializer->serialize($order, 'json');

        $response = new Response($jsonContent);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

}
