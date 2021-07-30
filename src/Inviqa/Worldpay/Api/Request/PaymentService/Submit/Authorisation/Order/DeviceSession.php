<?php

namespace Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order;

use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\DeviceSession\SessionId;
use Inviqa\Worldpay\Api\XmlNodeDefaults;

class DeviceSession extends XmlNodeDefaults
{
    private $sessionId;

    public function __construct(
        SessionId $sessionId
    ) {
        $this->sessionId = $sessionId;
    }

    public function xmlChildren()
    {
        return [
            $this->sessionId,
        ];
    }
}