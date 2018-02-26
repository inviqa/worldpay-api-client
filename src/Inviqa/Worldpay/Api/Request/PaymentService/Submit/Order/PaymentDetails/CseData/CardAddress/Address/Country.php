<?php

namespace Inviqa\Worldpay\Api\Request\PaymentService\Submit\Order\PaymentDetails\CseData\CardAddress\Address;

class Country
{
    private $string;

    public function __construct(string $string) {
        $this->string = $string;
    }
}
