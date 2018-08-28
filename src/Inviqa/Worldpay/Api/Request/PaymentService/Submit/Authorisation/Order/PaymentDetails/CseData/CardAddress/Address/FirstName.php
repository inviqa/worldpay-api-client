<?php

namespace Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\CseData\CardAddress\Address;

use Inviqa\Worldpay\Api\XmlNodeDefaults;

class FirstName extends XmlNodeDefaults
{
    public function xmlLabel()
    {
        return 'firstName';
    }
}
