<?php

namespace Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\FraudSightData\ShopperFields\BirthDate\Date;

use Inviqa\Worldpay\Api\XmlAttributeDefaults;

class DayOfMonth extends XmlAttributeDefaults
{
    public function __construct(string $string = null)
    {
        $this->string = $string;
    }
}
