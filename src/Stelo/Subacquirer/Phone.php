<?php
namespace Stelo\Subacquirer;

class Phone
{
    const TYPE_CELL = 'CELL';
    const TYPE_LANDLINE = 'LANDLINE';

    public $areaCode;

    public $number;

    public $type;

    public function __construct($areaCode, $number, $type)
    {
        $this->areaCode = $areaCode;
        $this->number = $number;
        $this->type = $type;
    }

    public function getAreaCode()
    {
        return $this->areaCode;
    }

    public function setAreaCode($areaCode)
    {
        $this->areaCode = $areaCode;
        return $this;
    }

    public function getNumber()
    {
        return $this->number;
    }

    public function setNumber($number)
    {
        $this->number = $number;
        return $this;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }
}
