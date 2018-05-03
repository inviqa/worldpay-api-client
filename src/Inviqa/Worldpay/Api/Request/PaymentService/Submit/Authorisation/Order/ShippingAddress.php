<?php

namespace Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order;

use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\CseData\CardAddress\Address;
use Inviqa\Worldpay\Api\XmlNodeDefaults;

class ShippingAddress extends XmlNodeDefaults
{
    private $address;

    public function __construct(
        Address $address
    ) {
        $this->address = $address;
    }

    public function xmlChildren()
    {
        return [
            $this->address,
        ];
    }
}
