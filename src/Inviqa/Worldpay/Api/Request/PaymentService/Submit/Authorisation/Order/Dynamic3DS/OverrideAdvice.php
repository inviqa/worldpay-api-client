<?php

namespace Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Dynamic3DS;

use Inviqa\Worldpay\Api\XmlAttributeDefaults;

class OverrideAdvice extends XmlAttributeDefaults
{
    public function __construct() {
        parent::__construct('do3DS');
    }
}
