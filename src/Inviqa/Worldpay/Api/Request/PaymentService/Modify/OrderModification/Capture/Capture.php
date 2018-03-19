<?php

namespace Inviqa\Worldpay\Api\Request\PaymentService\Modify\OrderModification\Capture;

use Inviqa\Worldpay\Api\Request\PaymentService\Modify\OrderModification;
use Inviqa\Worldpay\Api\XmlNodeDefaults;

class Capture extends XmlNodeDefaults implements OrderModification
{
    private $amount;

    public function __construct(
        Amount $amount
    ) {
        $this->amount = $amount;
    }

    public function xmlChildren()
    {
        return [
            $this->amount
        ];
    }
}
