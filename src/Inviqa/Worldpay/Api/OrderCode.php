<?php

namespace Inviqa\Worldpay\Api;

class OrderCode
{
    private $string;

    public function __construct($string)
    {
        $this->string = $string;
    }

    public function __toString()
    {
        return (string)$this->string;
    }

    public function equals(OrderCode $orderCode)
    {
        return (string)$this === (string)$orderCode;
    }
}
