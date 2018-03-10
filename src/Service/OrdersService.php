<?php

namespace App\Service;

use App\Entity\Order;
use App\Entity\Product;
use App\Entity\User;
use App\Repository\OrderRepository;
use App\Repository\ShoppingCartRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;

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
    public function save(User $user): Order
    {
        $shoppingCart = $this->shoppingCartRepository->findOneBy(['user' => $user]);


        if (!$shoppingCart || !$shoppingCart->getProducts()->count() > 0) {
            throw new EntityNotFoundException("The user shopping cart is empty");
        }

        $order = new Order();
        $order->setUser($user);

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

        $this->em->flush();

        return $order;
    }

}