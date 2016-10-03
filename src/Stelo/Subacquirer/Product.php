<?php
namespace Stelo\Subacquirer;

class Product
{

    public $productName;

    public $productPrice;

    public $productQuantity;

    public $productSku;
    
    public function __construct($name, $price, $quantity = 1, $sku = null)
    {
        $this->productName = $name;
        $this->productPrice = $price;
        $this->productQuantity = $quantity;
        $this->productSku = $sku;
    }

    public function getProductName()
    {
        return $this->productName;
    }

    public function setProductName($productName)
    {
        $this->productName = $productName;
        return $this;
    }

    public function getProductPrice()
    {
        return $this->productPrice;
    }

    public function setProductPrice($productPrice)
    {
        $this->productPrice = $productPrice;
        return $this;
    }

    public function getProductQuantity()
    {
        return $this->productQuantity;
    }

    public function setProductQuantity($productQuantity)
    {
        $this->productQuantity = $productQuantity;
        return $this;
    }

    public function getProductSku()
    {
        return $this->productSku;
    }

    public function setProductSku($productSku)
    {
        $this->productSku = $productSku;
        return $this;
    }
}
