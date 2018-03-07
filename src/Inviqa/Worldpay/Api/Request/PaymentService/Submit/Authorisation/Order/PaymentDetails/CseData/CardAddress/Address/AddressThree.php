<?php

namespace Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\CseData\CardAddress\Address;

use Inviqa\Worldpay\Api\XmlNodeDefaults;

class AddressThree extends XmlNodeDefaults
{
    public function __construct(string $string = null)
    {
        $this->string = $string;
    }

    public function xmlLabel()
    {
        return 'address3';
    }
}
