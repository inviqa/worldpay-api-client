<?php

namespace Inviqa\Worldpay\Api\Request\PaymentService\Submit\ThreeDS;

use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Order;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\ThreeDS\Order\Info3DSFlex;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\ThreeDS\Order\OrderCode;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\ThreeDS\Order\Session;
use Inviqa\Worldpay\Api\XmlNodeDefaults;

class ThreeDSFlexOrder extends XmlNodeDefaults implements Order
{
    private $orderCode;
    private $info3DSecure;
    private $session;

    public function __construct(
        OrderCode $orderCode,
        Info3DSFlex $info3DSecure,
        Session $session
    ) {
        $this->orderCode    = $orderCode;
        $this->info3DSecure = $info3DSecure;
        $this->session      = $session;
    }

    public function xmlChildren()
    {
        return [
            $this->orderCode,
            $this->info3DSecure,
            $this->session
        ];
    }

    public function xmlLabel()
    {
        return 'order';
    }
}
