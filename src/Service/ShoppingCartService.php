<?php

namespace App\Service;

use App\Entity\Product;
use App\Entity\ShoppingCart;
use App\Entity\User;
use App\Repository\ShoppingCartRepository;
use Doctrine\ORM\EntityManagerInterface;

class ShoppingCartService
{
    private $repository;
    private $em;

    public function __construct(ShoppingCartRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    public function save(Product $product, User $user): ShoppingCart
    {
        $shoppingCart = $this->repository->findOneBy(['user' => $user]);

        if (!$shoppingCart) {
            $shoppingCart = new ShoppingCart();
            $shoppingCart->setUser($user);
        }

        $shoppingCart->addProduct($product);
        $product->addCart($shoppingCart);

        $this->em->persist($product);
        $this->em->persist($shoppingCart);

        $this->em->flush();

        return $shoppingCart;
    }
}