<?php

namespace App\Controller;


use App\Service\OrdersService;
use Doctrine\ORM\EntityNotFoundException;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\User\UserInterface;

class OrdersController extends Controller
{
    private $serializer;
    private $ordersService;

    public function __construct(OrdersService $ordersService, SerializerInterface $serializer)
    {
        $this->ordersService = $ordersService;
        $this->serializer = $serializer;
    }

    /**
     * @Route("order/create", name="createOrder", methods="POST")
     * @throws EntityNotFoundException
     */
    public function store(UserInterface $user)
    {
        $order = $this->ordersService->save($user);

        return JsonResponse::fromJsonString($this->serializer->serialize($order, 'json'));
    }
}