<?php

namespace App\Service;

use App\Entity\Bundle;
use App\Entity\Discount;
use App\Entity\Product;
use App\Exceptions\InvalidParametersException;
use App\Repository\CategoryRepository;
use App\Repository\DiscountRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;

class ProductsService
{
    private $repository;
    private $categoryRepository;
    private $discountRepository;
    private $em;


    public function __construct(ProductRepository $repository, CategoryRepository $categoryRepository, DiscountRepository $discountRepository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->categoryRepository = $categoryRepository;
        $this->discountRepository = $discountRepository;
        $this->em = $em;
    }

    public function getAll()
    {
        return $this->repository->findAll();
    }

    /**
     * @throws InvalidParametersException
     */
    public function save($json): Product
    {
        $content = json_decode($json, true);

        $category = $this->categoryRepository->find($content["category"]["id"]);

        if(!$category){
            throw new InvalidParametersException("The Category does not exist");
        }

        $children = isset($content["children"]) ? $content["children"] : [];

        if($content["type"] == "product"){
            $product = new Product();
        }elseif($content["type"] == "bundle"){
            $product = new Bundle();
        }else{
            throw new InvalidParametersException("The type does not exist");
        }
        $product->setName($content["name"]);
        $product->setDescription($content["description"]);
        $product->setPrice($content["price"]);

        $product->setCategory($category);

        $product->setCreatedAt(new \DateTime());
        $product->setUpdatedAt(new \DateTime());

        $this->repository->save($product);

        if ($product instanceof Bundle && count($children) == 0) {
            throw new InvalidParametersException("When creating a Bundle, children array must be specified and cannot be empty");
        }

        foreach ($children as $id) {
            $p = $this->repository->find($id);
            $product->addChildren($p);
            $this->em->persist($p);
        }

        $this->em->persist($product);
        $this->em->flush();

        $discount = new Discount($content["discount"]["type"], $content["discount"]["discount"]);
        $discount->setProduct($product);

        $this->discountRepository->save($discount);

        return $product;
    }

}