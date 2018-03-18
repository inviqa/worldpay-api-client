<?php

namespace Inviqa\Worldpay\Api\Request\PaymentService\Modify\OrderModification;

use Inviqa\Worldpay\Api\Request\PaymentService\Modify\OrderModification;
use Inviqa\Worldpay\Api\Request\PaymentService\Modify\OrderModification\Capture\Capture;
use Inviqa\Worldpay\Api\XmlNodeDefaults;

class CaptureModification extends XmlNodeDefaults implements OrderModification
{
    private $capture;
    private $orderCode;

    public function __construct(
        OrderCode $orderCode,
        Capture $capture
    ) {
        $this->orderCode = $orderCode;
        $this->capture = $capture;
    }

    public function xmlChildren()
    {
        return [
            $this->orderCode,
            $this->capture
        ];
    }

    public function xmlLabel()
    {
        return 'orderModification';
    }
}
