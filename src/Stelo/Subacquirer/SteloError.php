<?php
namespace Stelo\Subacquirer;

class SteloError
{
    private $errorCode;
    private $errorMessage;
    private $details = [];
    
    public function __construct($errorCode, $errorMessage)
    {
        $this->errorCode = $errorCode;
        $this->errorMessage = $errorMessage;
    }
    
    public function addDetail($message)
    {
        $this->details[] = $message;
    }
    
    public function getDetailIterator()
    {
        return new \ArrayIterator($this->details);
    }

    public function getErrorCode()
    {
        return $this->errorCode;
    }

    public function getErrorMessage()
    {
        return $this->errorMessage;
    }
 
}