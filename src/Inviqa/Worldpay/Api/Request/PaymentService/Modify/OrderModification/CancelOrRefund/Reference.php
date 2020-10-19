<?php

namespace Inviqa\Worldpay\Api\Request\PaymentService\Modify\OrderModification\CancelOrRefund;

use Inviqa\Worldpay\Api\XmlAttributeDefaults;

class Reference extends XmlAttributeDefaults
{
    public function __construct(string $string = null)
    {
        $this->string = $string;
    }
}
