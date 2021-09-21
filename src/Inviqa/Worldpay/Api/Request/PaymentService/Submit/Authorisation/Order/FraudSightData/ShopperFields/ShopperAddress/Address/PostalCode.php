<?php

namespace Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\FraudSightData\ShopperFields\ShopperAddress\Address;

use Inviqa\Worldpay\Api\XmlNodeDefaults;

class PostalCode extends XmlNodeDefaults
{
    public function __construct(string $string = null)
    {
        $this->string = $string;
    }
}
