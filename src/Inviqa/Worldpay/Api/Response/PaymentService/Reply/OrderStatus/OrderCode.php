<?php

namespace Inviqa\Worldpay\Api\Response\PaymentService\Reply\OrderStatus;

class OrderCode
{
    private $string;

    public function __construct(string $string)
    {
        $this->string = $string;
    }

    public function equals(OrderCode $orderCode)
    {
        return $this->string === $orderCode->string;
    }

    public function __toString()
    {
        return (string)$this->string;
    }
}
