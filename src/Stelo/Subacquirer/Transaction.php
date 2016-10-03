<?php
namespace Stelo\Subacquirer;

class Transaction
{

    public $orderData;

    public $paymentData;

    public $customerData;

    public $bankSlipURL;
    
    public function __construct(Order $order, Payment $payment, Customer $customer)
    {
        $this->orderData = $order;
        $this->paymentData = $payment;
        $this->customerData = $customer;
    }

    public function getOrder()
    {
        return $this->orderData;
    }

    public function setOrder(Order $orderData)
    {
        $this->orderData = $orderData;
        return $this;
    }

    public function getPayment()
    {
        return $this->paymentData;
    }

    public function setPayment(Payment $paymentData)
    {
        $this->paymentData = $paymentData;
        return $this;
    }

    public function getCustomer()
    {
        return $this->customerData;
    }

    public function setCustomer(Customer $customerData)
    {
        $this->customerData = $customerData;
        return $this;
    }

    public function getBankSlipURL()
    {
        return $this->bankSlipURL;
    }

    public function setBankSlipURL($bankSlipURL)
    {
        $this->bankSlipURL = $bankSlipURL;
        return $this;
    }
}
