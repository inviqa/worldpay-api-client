<?php

namespace Inviqa\Worldpay\Api\Request\PaymentService\Modify\OrderModification\Capture;

use Inviqa\Worldpay\Api\Request\PaymentService\Modify\OrderModification;
use Inviqa\Worldpay\Api\XmlNodeDefaults;
use Inviqa\Worldpay\Api\Request\PaymentService\Modify\OrderModification\Capture\Capture\Reference;

class Capture extends XmlNodeDefaults implements OrderModification
{
    private $amount;
    private $reference;

    public function __construct(
        Amount $amount,
        ?Reference $reference = null
    ) {
        $this->amount = $amount;
        $this->reference = $reference;
    }

    public function xmlChildren()
    {
        return [
            $this->reference,
            $this->amount,
        ];
    }
}
