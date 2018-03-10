<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    private $manager;

    public function __construct(RegistryInterface $registry, ObjectManager $manager)
    {
        parent::__construct($registry, Product::class);
        $this->manager = $manager;
    }

    public function save(Product $product) : Product
    {
        $this->manager->persist($product);
        $this->manager->flush();

        return $product;
    }
}
