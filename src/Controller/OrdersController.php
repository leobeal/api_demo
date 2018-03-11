<?php

namespace App\Controller;

use App\Exceptions\UserNotLoggedInException;
use App\Service\OrdersService;
use Doctrine\ORM\EntityNotFoundException;
use JMS\Serializer\SerializerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
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
     * @Route("api/order/create", name="createOrder", methods="POST")
     * @\Nelmio\ApiDocBundle\Annotation\Security(name="basic")
     *
     * Store an Order
     *
     * @SWG\Response(
     *     response=200,
     *     description="Store an Order",
     *     @SWG\Schema(
     *         type="array",
     *         @Model(type=App\Entity\Order::class)
     *     )
     * )
     * @SWG\Tag(name="orders")
     * @throws UserNotLoggedInException
     * @throws EntityNotFoundException
     */
    public function store(UserInterface $user = null)
    {
        if (!$user) {
            throw new UserNotLoggedInException();
        }

        $order = $this->ordersService->save($user);

        return JsonResponse::fromJsonString($this->serializer->serialize($order, 'json'));
    }
}