<?php

namespace Inviqa\Worldpay\Api\Request\Order\PaymentDetails\CseData\CardAddress\Address;

use Inviqa\Worldpay\Api\XmlNodeDefaults;

class AddressOne extends XmlNodeDefaults
{
    public function xmlLabel()
    {
        return 'address1';
    }
}
