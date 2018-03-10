<?php
declare(strict_types=1);

namespace App\Entity;

use App\Traits\TimestampTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
{
    use TimestampTrait;

    public function __construct()
    {
        $this->createdAt= new \DateTime();
        $this->updatedAt= new \DateTime();

        $this->children = new ArrayCollection();
        $this->bundles = new ArrayCollection();
        $this->orders = new ArrayCollection();
        $this->carts = new ArrayCollection();
    }

    /**
     * @var integer
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=100)
     *
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @var float
     * @ORM\Column(type="decimal", scale=2, nullable=false)
     */
    private $price;

    /**
     * @var string
     * @ORM\Column(type="string", columnDefinition="ENUM('normal', 'grouped')")
     */
    private $type;

    /**
     * @var Discount|null
     * @ORM\OneToOne(targetEntity="App\Entity\Discount", mappedBy="product", cascade={"persist", "remove"})
     * @Serializer\Exclude()
     */
    private $discount;

    /**
     * @var Category
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="products", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @var Order[]|null
     * @ORM\ManyToMany(targetEntity="App\Entity\Order",inversedBy="products")
     * @ORM\JoinTable(name="product_order")
     * @Serializer\Exclude()
     */
    private $orders;

    /**
     * @var ArrayCollection|null
     * @ORM\ManyToMany(targetEntity="App\Entity\ShoppingCart",inversedBy="products")
     * @ORM\JoinTable(name="product_shopping_cart")
     * @Serializer\Exclude()
     *
     */
    private $carts;

    /**
     * A product can be in more than one Bundle
     * @ORM\ManyToMany(targetEntity="App\Entity\Product", mappedBy="children")
     * @Serializer\Exclude()
     */
    private $bundles;

    /**
     * A Bundle (Product) can have more than one (child)product
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="App\Entity\Product", inversedBy="parent")
     * @ORM\JoinTable(name="bundles",
     *      joinColumns={@ORM\JoinColumn(name="parent_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="children_id", referencedColumnName="id")}
     *      )
     */
    private $children;


    public function getChildren() : ArrayCollection
    {
        return $this->children;
    }

    public function setChildren(ArrayCollection $children): Product
    {
        $this->children = $children;
        return $this;
    }

    public function addChildren(Product $product): Product
    {
        $this->children->add($product);
        return $this;
    }

    public function getBundles(): ArrayCollection
    {
        return $this->bundles;
    }

    public function setBundles(ArrayCollection $bundles): Product
    {
        $this->bundles = $bundles;
        return $this;
    }


    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): Product
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Product
    {
        $this->name = $name;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): Product
    {
        $this->description = $description;
        return $this;
    }

    public function getPrice(): float
    {
        return (float)number_format((float)$this->price, 2);
    }

    public function setPrice(float $price): Product
    {
        $this->price = $price;
        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): Product
    {
        $this->type = $type;
        return $this;
    }

    public function getDiscount(): ?Discount
    {
        return $this->discount;
    }

    public function setDiscount(?Discount $discount): Product
    {
        $this->discount = $discount;
        return $this;
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function setCategory(Category $category): Product
    {
        $this->category = $category;
        return $this;
    }

    public function getOrders(): ArrayCollection
    {
        return $this->orders;
    }

    public function setOrders(ArrayCollection $orders): Product
    {
        $this->orders = $orders;
        return $this;
    }

    public function addOrder(Order $order): Product
    {
        $this->orders->add($order);
        return $this;
    }

    public function getCarts(): ArrayCollection
    {
        return $this->carts;
    }

    public function setCarts(ArrayCollection $carts): Product
    {
        $this->carts = $carts;
        return $this;
    }

    public function addCart(ShoppingCart $cart): Product
    {
        $this->carts->add($cart);
        return $this;
    }

    /**
     * @Serializer\VirtualProperty
     * @Serializer\SerializedName("finalPrice")
     */
    public function finalPrice()
    {
        if ($this->getDiscount()) {
            if ($this->getDiscount()->getType() == "percentage") {
                return (float)number_format((float)$this->getPrice() - ($this->getPrice() * $this->getDiscount()->getDiscount()) / 100, 2);
            }
            return (float)number_format($this->getPrice() - $this->getDiscount()->getDiscount(), 2);
        }

        return $this->getPrice();
    }
}
