<?php

namespace Inviqa\Worldpay\Api\Request\Order\PaymentDetails\CseData;

use Inviqa\Worldpay\Api\Request\Order\PaymentDetails\CseData\CardAddress\Address;

class CardAddress
{
    private $address;

    public function __construct(
        Address $address
    ) {
        $this->address = $address;
    }
}
