<?php

namespace App\Entity;

use App\Traits\TimestampTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ShoppingCartRepository")
 */
class ShoppingCart
{
    use TimestampTrait;

    public function __construct()
    {
        $this->createdAt= new \DateTime();
        $this->updatedAt= new \DateTime();

        $this->products= new ArrayCollection();
    }

    /**
     * @var string
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var ArrayCollection|null
     * @ORM\ManyToMany(targetEntity="App\Entity\Product",mappedBy="carts")
     *
     */
    private $products;

    /**
     * @var UserInterface
     * @ORM\OneToOne(targetEntity="App\Entity\User", inversedBy="cart")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): ShoppingCart
    {
        $this->id = $id;
        return $this;
    }

    public function getProducts()
    {
        return $this->products;
    }

    public function setProducts(ArrayCollection $products): ShoppingCart
    {
        $this->products = $products;
        return $this;
    }

    public function addProduct(Product $product): ShoppingCart
    {
        $this->products->add($product);
        return $this;
    }

    public function getUser(): UserInterface
    {
        return $this->user;
    }

    public function setUser(UserInterface $user): ShoppingCart
    {
        $this->user = $user;
        return $this;
    }
}
