<?php

namespace App\Entity;

use App\Traits\TimestampTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrderRepository")
 * @ORM\Table(name="orders")
 */
class Order
{
    use TimestampTrait;

    public function __construct()
    {
        $this->createdAt= new \DateTime();
        $this->updatedAt= new \DateTime();

        $this->products = new ArrayCollection();
    }
    /**
     * @var integer
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="App\Entity\Product",mappedBy="orders")
     *
     */
    private $products;

    /**
     * @var UserInterface
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="orders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): Order
    {
        $this->id = $id;
        return $this;
    }

    public function getProducts(): ArrayCollection
    {
        return $this->products;
    }

    public function setProducts(ArrayCollection $products): Order
    {
        $this->products = $products;
        return $this;
    }

    public function addProduct(Product $product): Order
    {
        $this->products->add($product);
        return $this;
    }

    public function getUser(): UserInterface
    {
        return $this->user;
    }

    public function setUser(UserInterface $user): Order
    {
        $this->user = $user;
        return $this;
    }
}
