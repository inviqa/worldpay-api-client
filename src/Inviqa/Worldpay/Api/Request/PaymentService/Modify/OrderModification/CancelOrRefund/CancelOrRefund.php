<?php

namespace Inviqa\Worldpay\Api\Request\PaymentService\Modify\OrderModification\CancelOrRefund;

use Inviqa\Worldpay\Api\Request\PaymentService\Modify\OrderModification;
use Inviqa\Worldpay\Api\XmlNodeDefaults;

class CancelOrRefund extends XmlNodeDefaults implements OrderModification
{
    private $amount;
    private $reference;

    public function __construct(
        Reference $reference,
        Amount $amount
    ) {
        $this->reference = $reference;
        $this->amount    = $amount;
    }

    public function xmlChildren()
    {
        return [
            $this->reference,
            $this->amount
        ];
    }
}
