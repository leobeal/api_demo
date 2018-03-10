<?php

namespace App\Entity;

use App\Traits\TimestampTrait;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category
{
    public function __construct()
    {
        $this->createdAt= new \DateTime();
        $this->updatedAt= new \DateTime();
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
     * @var string
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @var Product[]|null
     * @ORM\OneToMany(targetEntity="App\Entity\Product", mappedBy="category")
     * @Serializer\Exclude()
     */
    private $products;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): Category
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Category
    {
        $this->name = $name;
        return $this;
    }

    public function getProducts(): ?array
    {
        return $this->products;
    }

    public function setProducts(?array $products): Category
    {
        $this->products = $products;
        return $this;
    }
}
