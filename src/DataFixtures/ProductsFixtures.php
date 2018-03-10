<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ProductsFixtures extends Fixture
{

    public function __construct()
    {

    }

    public function load(ObjectManager $manager)
    {
        $category = new Category();
        $category->setName("new Category");

        // create 20 products! Bam!
        for ($i = 0; $i < 20; $i++) {
            $product = new Product();
            $product->setName('product ' . $i);
            $product->setDescription('desc ' . $i);
            $product->setCreatedAt(new \DateTime());
            $product->setUpdatedAt(new \DateTime());
            $product->setCategory($category);


            $product->setPrice(mt_rand(10, 100));
            $manager->persist($product);
        }

        $manager->flush();
    }
}