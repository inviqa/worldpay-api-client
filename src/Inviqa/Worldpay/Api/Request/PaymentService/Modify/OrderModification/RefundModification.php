<?php

namespace Inviqa\Worldpay\Api\Request\PaymentService\Modify\OrderModification;

use Inviqa\Worldpay\Api\Request\PaymentService\Modify\OrderModification;
use Inviqa\Worldpay\Api\Request\PaymentService\Modify\OrderModification\Refund\Refund;
use Inviqa\Worldpay\Api\XmlNodeDefaults;

class RefundModification extends XmlNodeDefaults implements OrderModification
{
    private $refund;
    private $orderCode;

    public function __construct(
        OrderCode $orderCode,
        Refund $refund
    ) {
        $this->orderCode = $orderCode;
        $this->refund = $refund;
    }

    public function xmlChildren()
    {
        return [
            $this->orderCode,
            $this->refund
        ];
    }

    public function xmlLabel()
    {
        return 'orderModification';
    }
}
