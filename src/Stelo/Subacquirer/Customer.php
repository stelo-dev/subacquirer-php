<?php
namespace Stelo\Subacquirer;

class Customer
{

    public $customerIdentity;

    public $customerName;

    public $customerEmail;

    public $birthDate;

    public $billingAddress;

    public $shippingAddress;

    public $phoneData = [];

    public $gender;

    public function addNewPhone($areaCode, $number, $type)
    {
        return $this->addPhone(new Phone($areaCode, $number, $type));
    }

    public function addPhone(Phone $phone)
    {
        $this->phoneData[] = $phone;
        
        return $this;
    }

    public function getIdentity()
    {
        return $this->customerIdentity;
    }

    public function setIdentity($customerIdentity)
    {
        $this->customerIdentity = $customerIdentity;
        return $this;
    }

    public function getName()
    {
        return $this->customerName;
    }

    public function setName($customerName)
    {
        $this->customerName = $customerName;
        return $this;
    }

    public function getEmail()
    {
        return $this->customerEmail;
    }

    public function setEmail($customerEmail)
    {
        $this->customerEmail = $customerEmail;
        return $this;
    }

    public function getBirthDate()
    {
        return $this->birthDate;
    }

    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;
        return $this;
    }

    public function getBillingAddress()
    {
        return $this->billingAddress;
    }

    public function setBillingAddress($billingAddress)
    {
        $this->billingAddress = $billingAddress;
        return $this;
    }

    public function getShippingAddress()
    {
        return $this->shippingAddress;
    }

    public function setShippingAddress($shippingAddress)
    {
        $this->shippingAddress = $shippingAddress;
        return $this;
    }

    public function getPhoneData()
    {
        return $this->phoneData;
    }

    public function setPhoneData($phoneData)
    {
        $this->phoneData = $phoneData;
        return $this;
    }

    public function getGender()
    {
        return $this->gender;
    }

    public function setGender($gender)
    {
        $this->gender = $gender;
        return $this;
    }
}
