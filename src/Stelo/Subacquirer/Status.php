<?php
namespace Stelo\Subacquirer;

class Status
{

    public $statusCode;

    public $statusMessage;
    
    public function __construct($statusCode, $statusMessage)
    {
        $this->statusCode = $statusCode;
        $this->statusMessage = $statusMessage;
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    public function getStatusMessage()
    {
        return $this->statusMessage;
    }

    public function setStatusMessage($statusMessage)
    {
        $this->statusMessage = $statusMessage;
        return $this;
    }
}
