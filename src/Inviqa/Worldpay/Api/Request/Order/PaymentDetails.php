<?php

namespace Inviqa\Worldpay\Api\Request\Order;

use Inviqa\Worldpay\Api\Request\Order\PaymentDetails\CseData;
use Inviqa\Worldpay\Api\Request\Order\PaymentDetails\Session;

class PaymentDetails
{
    private $cseData;
    private $session;

    public function __construct(
        CseData $cseData,
        Session $session
    ) {
        $this->cseData = $cseData;
        $this->session = $session;
    }
}
