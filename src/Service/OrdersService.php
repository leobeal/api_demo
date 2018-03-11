<?php

namespace App\Service;

use App\Entity\Order;
use App\Entity\Product;
use App\Entity\User;
use App\Repository\OrderRepository;
use App\Repository\ShoppingCartRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;

class OrdersService
{
    private $repository;
    private $shoppingCartRepository;
    private $em;

    public function __construct(OrderRepository $repository, ShoppingCartRepository $shoppingCartRepository,  EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->shoppingCartRepository = $shoppingCartRepository;
        $this->em = $em;
    }

    /**
     * @throws EntityNotFoundException
     */
    public function save(UserInterface $user): Order
    {
        $shoppingCart = $this->shoppingCartRepository->findOneBy(['user' => $user]);


        if (!$shoppingCart || !$shoppingCart->getProducts()->count() > 0) {
            throw new EntityNotFoundException("The user shopping cart is empty");
        }

        $order = new Order();
        $order->setUser($user);

        //calculates the order total price based on products in the shopping cart
        $order->setPrice($shoppingCart->finalPrice());

        $this->em->persist($user);
        $this->em->persist($order);

        $this->em->flush();

        foreach ($shoppingCart->getProducts() as $product){
            /** @var Product $product */
            $order->addProduct($product);
            $product->addOrder($order);
            $this->em->persist($product);
        }

        $this->em->persist($order);
        $this->em->remove($shoppingCart);

        $this->em->flush();

        return $order;
    }

}