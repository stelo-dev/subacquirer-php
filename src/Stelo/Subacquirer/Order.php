<?php
namespace Stelo\Subacquirer;

class Order
{

    public $amount;

    public $autorizationId;

    public $freight;

    public $installment;

    public $nsu;

    public $orderId;

    public $secureCode;

    public $shippingBehavior = "DEFAULT";

    public $steloId;

    public $steloStatus;

    public $tid;

    public function __construct($orderId, $shippingBehavior = 'default')
    {
        $this->setOrderId($orderId);
        $this->setShippingBehavior($shippingBehavior);
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

    public function getAutorizationId()
    {
        return $this->autorizationId;
    }

    public function setAutorizationId($autorizationId)
    {
        $this->autorizationId = $autorizationId;
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

    public function getInstallment()
    {
        return $this->installment;
    }

    public function setInstallment($installment)
    {
        $this->installment = $installment;
        return $this;
    }

    public function getNsu()
    {
        return $this->nsu;
    }

    public function setNsu($nsu)
    {
        $this->nsu = $nsu;
        return $this;
    }

    public function getOrderId()
    {
        return $this->orderId;
    }

    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;
        return $this;
    }

    public function getSecureCode()
    {
        return $this->secureCode;
    }

    public function setSecureCode($secureCode)
    {
        $this->secureCode = $secureCode;
        return $this;
    }

    public function getShippingBehavior()
    {
        return $this->shippingBehavior;
    }

    public function setShippingBehavior($shippingBehavior)
    {
        switch ($shippingBehavior) {
            case 'default':
            case 'digital':
            case 'express':
            case 'extensive':
            case 'fast':
            case 'service':
            case 'storePickup':
                $this->shippingBehavior = $shippingBehavior;
                break;
            default:
                throw new \UnexpectedValueException('Unexpected shipping behavior: "' . $shippingBehavior . '"');
        }
        
        return $this;
    }

    public function getSteloId()
    {
        return $this->steloId;
    }

    public function setSteloId($steloId)
    {
        $this->steloId = $steloId;
        return $this;
    }

    public function getSteloStatus()
    {
        return $this->steloStatus;
    }

    public function setSteloStatus($steloStatus)
    {
        $this->steloStatus = $steloStatus;
        return $this;
    }

    public function getTid()
    {
        return $this->tid;
    }

    public function setTid($tid)
    {
        $this->tid = $tid;
        return $this;
    }
}
