<?php

namespace Inviqa\Worldpay\Api\Request\PaymentService\Modify\OrderModification;

use Inviqa\Worldpay\Api\Request\PaymentService\Modify\OrderModification;
use Inviqa\Worldpay\Api\Request\PaymentService\Modify\OrderModification\Cancel\Cancel;
use Inviqa\Worldpay\Api\XmlNodeDefaults;

class CancelModification extends XmlNodeDefaults implements OrderModification
{
    private $cancel;
    private $orderCode;

    public function __construct(
        OrderCode $orderCode,
        Cancel $cancelOrRefund
    ) {
        $this->orderCode = $orderCode;
        $this->cancel    = $cancelOrRefund;
    }

    public function xmlChildren()
    {
        return [
            $this->orderCode,
            $this->cancel
        ];
    }

    public function xmlLabel()
    {
        return 'orderModification';
    }
}
