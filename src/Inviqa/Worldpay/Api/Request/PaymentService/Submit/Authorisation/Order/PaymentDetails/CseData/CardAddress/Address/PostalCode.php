<?php

namespace Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\CseData\CardAddress\Address;

use Inviqa\Worldpay\Api\XmlNodeDefaults;

class PostalCode extends XmlNodeDefaults
{
    const DEFAULT_VALUE = "000000";

    public function __construct(string $string = null)
    {
        if (empty($string)) {
            $string = self::DEFAULT_VALUE;
        }

        $this->string = $string;
    }
}
