<?php

namespace App\Controller;

use App\Entity\Product;
use App\Service\ShoppingCartService;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class ShoppingCartController extends Controller
{
    private $serializer;
    private $shoppingCartService;

    public function __construct(ShoppingCartService $shoppingCartService, SerializerInterface $serializer)
    {
        $this->shoppingCartService = $shoppingCartService;
        $this->serializer = $serializer;
    }

    /**
     * @Route("basket/add/{id}", name="saveBasket", methods="PUT")
     */
    public function store(Product $product, UserInterface $user = null)
    {
        $shoppingCart = $this->shoppingCartService->save($product, $user);

        return JsonResponse::fromJsonString($this->serializer->serialize($shoppingCart, 'json'));
    }
}
