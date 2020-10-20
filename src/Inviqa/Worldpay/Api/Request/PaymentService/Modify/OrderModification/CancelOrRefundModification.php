<?php

namespace Inviqa\Worldpay\Api\Request\PaymentService\Modify\OrderModification;

use Inviqa\Worldpay\Api\Request\PaymentService\Modify\OrderModification;
use Inviqa\Worldpay\Api\Request\PaymentService\Modify\OrderModification\CancelOrRefund\CancelOrRefund;
use Inviqa\Worldpay\Api\XmlNodeDefaults;

class CancelOrRefundModification extends XmlNodeDefaults implements OrderModification
{
    private $cancelOrRefund;
    private $orderCode;

    public function __construct(
        OrderCode $orderCode,
        CancelOrRefund $cancelOrRefund
    ) {
        $this->orderCode = $orderCode;
        $this->cancelOrRefund    = $cancelOrRefund;
    }

    public function xmlChildren()
    {
        return [
            $this->orderCode,
            $this->cancelOrRefund
        ];
    }

    public function xmlLabel()
    {
        return 'orderModification';
    }
}
