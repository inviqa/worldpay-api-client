<?php

namespace Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Additional3DSData;

use Inviqa\Worldpay\Api\XmlAttributeDefaults;

class DfReferenceId extends XmlAttributeDefaults
{
    public function __construct(string $string = null)
    {
        $this->string = $string;
    }
}
