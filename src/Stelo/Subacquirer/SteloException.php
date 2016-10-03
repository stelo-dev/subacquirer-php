<?php
namespace Stelo\Subacquirer;

class SteloException extends \RuntimeException
{
    private $steloError;
    
    public function setSteloError(SteloError $steloError)
    {
        $this->steloError = $steloError;
    }
    
    public function getSteloError()
    {
        return $this->steloError;
    }
}