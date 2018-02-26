<?php

namespace Inviqa\Worldpay\Api\Request\PaymentService\Submit\Order\PaymentDetails\CseData;

use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Order\PaymentDetails\CseData\CardAddress\Address;
use Inviqa\Worldpay\Api\XmlNodeDefaults;

class CardAddress extends XmlNodeDefaults
{
    private $address;

    public function __construct(Address $address)
    {
        $this->address = $address;
    }

    public function xmlChildren()
    {
        return [$this->address];
    }
}
