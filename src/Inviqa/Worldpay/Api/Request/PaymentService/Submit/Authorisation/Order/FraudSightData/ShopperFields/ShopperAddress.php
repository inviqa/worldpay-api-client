<?php

namespace Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\FraudSightData\ShopperFields;

use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\FraudSightData\ShopperFields\ShopperAddress\Address;
use Inviqa\Worldpay\Api\XmlNodeDefaults;

class ShopperAddress extends XmlNodeDefaults
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
