<?php

namespace App\Controller;

use App\Entity\Item;
use App\Entity\ShipOrder;
use App\Entity\Person;
use App\Entity\Phone;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FileUploadController extends AbstractController
{

    /**
     * @Route("/", name="file_upload")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        //todo Validar o tipo do arquivo para xml

        $form = $this->createFormBuilder(['message' => 'Teste de mensagem'])
            ->add('file', FileType::class)
            ->add('save', SubmitType::class, array('label' => 'Process your file'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $parsedData = $this->parseXML($data['file']);

            foreach ($parsedData as $type => $content) {
                if ($type == 'person') {
                    $this->savePeople($content);
                } elseif ($type == 'shiporder') {
                    $this->saveOrders($content);
                }
            }
        }

        return $this->render('file_upload/index.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    private function savePersonPhones($phones, Person $person)
    {
        $savePhone = function (Person $person, int $phoneNumber) {
            $entityManager = $this->getDoctrine()->getManager();
            $phone = $this->getDoctrine()
                ->getRepository(Phone::class)
                ->findOneBy([
                    'person'   => $person->getId(),
                    'number'   => $phoneNumber
                ]);

            if (!$phone) {
                $phone = new Phone();
            }

            $phone->setNumber($phoneNumber);
            $phone->setPerson($person);
            $entityManager->persist($phone);
        };

        if (!empty($phones) && !empty($phones['phone'])) {
            if (is_array($phones['phone'])) {
                foreach ($phones['phone'] as $phone) {
                    $savePhone($person, $phone);
                }
            } else {
                $savePhone($person, $phones['phone']);
            }
        }
    }

    private function savePeople(array $people)
    {
        if (empty($people))
            return;

        $entityManager = $this->getDoctrine()->getManager();

        $savePerson = function ($person) use ($entityManager) {
            $newPerson = $this->getDoctrine()
                ->getRepository(Person::class)
                ->findOneBy(['personId' => $person['personid']]);

            if (!$newPerson) {
                $newPerson = new Person();
                $newPerson->setPersonId($person['personid']);
            }

            $newPerson->setName($person['personname']);
            $this->savePersonPhones($person['phones'], $newPerson);
            $entityManager->persist($newPerson);
        };

        if (isset($people['personid'])) {
            $savePerson($people);
        } else {
            foreach ($people as $person) {
                $savePerson($person);
            }
        }

        $entityManager->flush();
    }

    private function saveOrderItems($items, ShipOrder $order)
    {
        $saveItem = function ($newItem, ShipOrder $order) {

            $entityManager = $this->getDoctrine()->getManager();

            $item = $this->getDoctrine()
                ->getRepository(Item::class)
                ->findOneBy([
                    'shipOrder' => $order->getId(),
                    'title'     => $newItem['title']
                ]);

            if (!$item) {
                $item = new Item();
            }

            $item->setTitle($newItem['title']);
            $item->setNote($newItem['note']);
            $item->setQuantity($newItem['quantity']);
            $item->setPrice($newItem['price']);
            $item->setShipOrder($order);

            $entityManager->persist($item);
        };

        if (isset($items['item']['title'])) {
            $saveItem($items['item'], $order);
        } else {
            foreach ($items['item'] as $item) {
                $saveItem($item, $order);
            }
        }
    }

    private function saveOrders(array $orders)
    {
        if (empty($orders))
            return;

        $entityManager = $this->getDoctrine()->getManager();

        $saveOrder = function ($newOrder) use ($entityManager) {

            $customer = $this->getDoctrine()
                ->getRepository(Person::class)
                ->findOneBy(['personId' => $newOrder['orderperson']]);

            if (!$customer) {
                return;
            }

            $order = $this->getDoctrine()
                ->getRepository(ShipOrder::class)
                ->findOneBy(['orderId' => $newOrder['orderid']]);

            if (!$order) {
                $order = new ShipOrder();
            }

            $order->setOrderId($newOrder['orderid']);
            $order->setOrderPerson($customer);
            $order->setShippingName($newOrder['shipto']['name']);
            $order->setShippingAddress($newOrder['shipto']['address']);
            $order->setShippingCity($newOrder['shipto']['city']);
            $order->setShippingCountry($newOrder['shipto']['country']);

            $this->saveOrderItems($newOrder['items'], $order);

            $entityManager->persist($order);
        };

        if (isset($orders['orderid'])) {
            $saveOrder($orders);
        } else {
            foreach ($orders as $order) {
                $saveOrder($order);
            }
        }

        $entityManager->flush();
    }

    /**
     * @param $file
     * @return mixed
     */
    private function parseXML($file): array
    {
        try {
            $xml = simplexml_load_file($file);
            return json_decode(json_encode($xml), true);
        } catch (\Exception $e) {
            throw new FileException("There is a problem with the uploaded XML file");
        }
    }
}
