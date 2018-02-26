<?php

namespace Inviqa\Worldpay\Api\Request\Order\PaymentDetails\CseData\CardAddress\Address;

class Country
{
    private $string;

    public function __construct(string $string) {
        $this->string = $string;
    }
}
