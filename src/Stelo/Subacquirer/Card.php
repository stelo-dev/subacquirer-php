<?php
namespace Stelo\Subacquirer;

class Card
{
    public $token;

    public function getToken()
    {
        return $this->token;
    }

    public function setToken($token)
    {
        $this->token = $token;
        return $this;
    }
}
