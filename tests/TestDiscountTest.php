<?php

namespace App\Tests;

use App\Entity\Discount;
use App\Entity\Product;
use PHPUnit\Framework\TestCase;

class TestDiscountTest extends TestCase
{
    public function testPercentageDiscount()
    {
        $product = new Product();
        $product->setPrice(10);

        $discount = new Discount("percentage",10);
        $product->setDiscount($discount);

        $this->assertEquals(9,$product->finalPrice());
    }

    public function testValueDiscount()
    {
        $product = new Product();
        $product->setPrice(10);

        $discount = new Discount("value",2);
        $product->setDiscount($discount);

        $this->assertEquals(8.0,$product->finalPrice());
    }
}
