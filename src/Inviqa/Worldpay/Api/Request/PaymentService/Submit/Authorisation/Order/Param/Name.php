<?php

namespace Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Param;

use Inviqa\Worldpay\Api\XmlAttributeDefaults;

class Name extends XmlAttributeDefaults
{
    public function xmlLabel()
    {
        return 'name';
    }
}
