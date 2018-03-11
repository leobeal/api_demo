<?php

namespace App\Controller;

use App\Entity\Product;
use App\Exceptions\InvalidParametersException;
use App\Exceptions\UserNotLoggedInException;
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
     * @throws UserNotLoggedInException
     * @throws InvalidParametersException
     */
    public function store(Product $product, UserInterface $user = null)
    {
        if(!$user){
            throw new UserNotLoggedInException();
        }
        $shoppingCart = $this->shoppingCartService->save($product, $user);

        return JsonResponse::fromJsonString($this->serializer->serialize($shoppingCart, 'json'));
    }
}
