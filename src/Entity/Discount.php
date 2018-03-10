<?php

namespace App\Entity;

use App\Traits\TimestampTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DiscountRepository")
 */
class Discount
{
    public function __construct(string $type, float $discount)
    {
        $this->createdAt= new \DateTime();
        $this->updatedAt= new \DateTime();

        $this->type = $type;
        $this->discount = $discount;
    }

    use TimestampTrait;

    /**
     * @var integer
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var integer
     * @ORM\Column(type="integer", nullable=true)
     */
    private $discount;

    /**
     * @var string
     * @ORM\Column(type="string", length=100)
     */
    private $type;

    /**
     * @var Product
     * @ORM\OneToOne(targetEntity="App\Entity\Product", inversedBy="discount")
     * @ORM\JoinColumn(nullable=true)
     */
    private $product;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): Discount
    {
        $this->id = $id;
        return $this;
    }

    public function getDiscount(): int
    {
        return $this->discount;
    }

    public function setDiscount(int $discount): Discount
    {
        $this->discount = $discount;
        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): Discount
    {
        $this->type = $type;
        return $this;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function setProduct(Product $product): Discount
    {
        $this->product = $product;
        return $this;
    }
}
