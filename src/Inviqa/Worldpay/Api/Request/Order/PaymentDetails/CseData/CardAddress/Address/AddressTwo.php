<?php

namespace Inviqa\Worldpay\Api\Request\Order\PaymentDetails\CseData\CardAddress\Address;

use Inviqa\Worldpay\Api\XmlNodeDefaults;

class AddressTwo extends XmlNodeDefaults
{
    public function xmlLabel()
    {
        return 'address2';
    }
}
