<?php

namespace Inviqa\Worldpay\Api\Request\PaymentService\Submit\Order\PaymentDetails\CseData\CardAddress\Address;

use Inviqa\Worldpay\Api\XmlNodeDefaults;

class State extends XmlNodeDefaults
{
    public function __construct(string $string = null)
    {
        $this->string = $string;
    }
}
