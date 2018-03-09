<?php

namespace Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order;

use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\CseData;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\Session;
use Inviqa\Worldpay\Api\XmlNodeDefaults;

class PaymentDetails extends XmlNodeDefaults
{
    private $cseData;
    private $session;

    public function __construct(
        CseData $cseData,
        Session $session
    )
    {
        $this->cseData = $cseData;
        $this->session = $session;
    }

    public function xmlChildren()
    {
        return [
            $this->cseData, $this->session
        ];
    }
}
