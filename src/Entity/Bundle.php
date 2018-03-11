<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Bundle extends Product
{
    public function __construct()
    {
        $this->children= new ArrayCollection();
        parent::__construct();
    }

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

    public function setChildren(ArrayCollection $children): self
    {
        $this->children = $children;
        return $this;
    }

    public function addChildren(Product $product): self
    {
        $this->children->add($product);
        return $this;
    }
}