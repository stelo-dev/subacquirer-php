<?php
namespace Stelo\Subacquirer;

class Payment
{

    const TYPE_BANK_SLIP = 'bankSlip';

    const TYPE_CREDIT = 'credit';

    public $paymentType;

    public $amount;

    public $freight;

    public $cartData = [];

    public $currency;

    public $cardData;

    public $installment;

    public $discountAmount;

    public function addNewProduct($name, $price, $quantity = 1, $sku = null)
    {
        return $this->addProduct(new Product($name, $price, $quantity, $sku));
    }

    public function addProduct(Product $product)
    {
        $this->cartData[] = $product;
        
        return $this;
    }

    public function getPaymentType()
    {
        return $this->paymentType;
    }

    public function setPaymentType($paymentType)
    {
        $this->paymentType = $paymentType;
        return $this;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function setAmount($amount)
    {
        $this->amount = $amount;
        return $this;
    }

    public function getFreight()
    {
        return $this->freight;
    }

    public function setFreight($freight)
    {
        $this->freight = $freight;
        return $this;
    }

    public function getCartData()
    {
        return $this->cartData;
    }

    public function setCartData($cartData)
    {
        $this->cartData = $cartData;
        return $this;
    }

    public function getCurrency()
    {
        return $this->currency;
    }

    public function setCurrency($currency)
    {
        $this->currency = $currency;
        return $this;
    }

    public function getCardData()
    {
        return $this->cardData;
    }

    public function setCardData($cardData)
    {
        $this->cardData = $cardData;
        return $this;
    }

    public function getInstallment()
    {
        return $this->installment;
    }

    public function setInstallment($installment)
    {
        $this->installment = $installment;
        return $this;
    }

    public function getDiscountAmount()
    {
        return $this->discountAmount;
    }

    public function setDiscountAmount($discountAmount)
    {
        $this->discountAmount = $discountAmount;
        return $this;
    }
}
