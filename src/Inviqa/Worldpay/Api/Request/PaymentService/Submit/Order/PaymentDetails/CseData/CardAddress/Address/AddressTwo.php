<?php

namespace Inviqa\Worldpay\Api\Request\PaymentService\Submit\Order\PaymentDetails\CseData\CardAddress\Address;

use Inviqa\Worldpay\Api\XmlNodeDefaults;

class AddressTwo extends XmlNodeDefaults
{
    public function __construct(string $string = null)
    {
        parent::__construct($string);
    }

    public function xmlLabel()
    {
        return 'address2';
    }
}
