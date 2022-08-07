<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Szwtdl\Paypal\Exceptions\InvalidArgumentException;
use Szwtdl\Paypal\Paypal;

class ProductTest extends TestCase
{
    public function testProductList()
    {
        $paypal = new Paypal("client_id", "client_key", "dev");
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid offset or limit null");
        $paypal->ProductList("1", "");
        $this->fail('Failed to assert ProductList throw exception with invalid argument.');
    }

    public function testProductCreate()
    {
        $paypal = new Paypal("client_id", "client_key", "dev");
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid name description type category image_url home_url");
        $paypal->ProductCreate("1", "20", "", "", "", "");
        $this->fail('Failed to assert ProductCreate throw exception with invalid argument.');
    }

    public function testProductDetail()
    {
        $paypal = new Paypal("client_id", "client_key", "dev");
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid product_id not null");
        $paypal->ProductDetail("");
        $this->fail('Failed to assert ProductDetail throw exception with invalid argument.');
    }

    public function testProductUpdate()
    {
        $paypal = new Paypal("client_id", "client_key", "dev");
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid product_id null or data not array");
        $paypal->ProductUpdate("2222","123456");
        $this->fail('Failed to assert ProductDetail throw exception with invalid argument.');
    }
}