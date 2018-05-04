<?php

namespace Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Param;

use Inviqa\Worldpay\Api\XmlValueDefaults;

class Value extends XmlValueDefaults
{
    public function __construct(string $string = null)
    {
        $this->string = $string;
    }
}
