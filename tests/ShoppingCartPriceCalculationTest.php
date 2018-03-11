<?php

namespace App\Tests;

use App\Entity\Discount;
use App\Entity\Product;
use App\Entity\ShoppingCart;
use PHPUnit\Framework\TestCase;

class ShoppingCartPriceCalculationTest extends TestCase
{
    public function testFinalPrice()
    {
        $p1 = new Product();
        $p1->setPrice(100);
        $d1 = new Discount("percentage",10);
        $p1->setDiscount($d1);

        //90
        $this->assertEquals(90.0,$p1->finalPrice());


        $p2 = new Product();
        $p2->setPrice(8);
        $d2 = new Discount("value",1);
        $p2->setDiscount($d2);

        //7
        $this->assertEquals(7,$p2->finalPrice());

        $cart = new ShoppingCart();

        $cart->addProduct($p1);
        $cart->addProduct($p2);

        $this->assertEquals(97.0,$cart->finalPrice());
    }
}
