<?php

namespace Stelo\Subacquirer;

class Card
{
    public $number;
    public $embossing;
    public $expiryDate;
    public $cvv;

    public function __construct($number, $embossing, $expiryDate, $cvv) {
        $this->setNumber($number);
        $this->setEmbossing($embossing);
        $this->setExpiryDate($expiryDate);
        $this->setCvv($cvv);
    }

    public function setNumber($number)
    {
        $this->number = str_replace(' ', '', $number);

        return $this;
    }

    public function getNumber()
    {
        return $this->number;
    }

    public function setEmbossing($embossing)
    {
        $this->embossing = $embossing;

        return $this;
    }

    public function getEmbossing()
    {
        return $this->embossing;
    }

    public function setExpiryDate($expiryDate)
    {
        $this->expiryDate = $expiryDate;

        return $this;
    }

    public function getExpiryDate()
    {
        return $this->expiryDate;
    }

    public function setCvv($cvv)
    {
        $this->cvv = $cvv;

        return $this;
    }

    public function getCvv()
    {
        return $this->cvv;
    }
}
