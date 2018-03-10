<?php

namespace App\Repository;

use App\Entity\Discount;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Discount|null find($id, $lockMode = null, $lockVersion = null)
 * @method Discount|null findOneBy(array $criteria, array $orderBy = null)
 * @method Discount[]    findAll()
 * @method Discount[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DiscountRepository extends ServiceEntityRepository
{
    private $manager;

    public function __construct(RegistryInterface $registry, ObjectManager $manager)
    {
        parent::__construct($registry, Discount::class);
        $this->manager = $manager;
    }

    public function save(Discount $product) : Discount
    {
        $this->manager->persist($product);
        $this->manager->flush();

        return $product;
    }
}
