<?php

namespace Inviqa\Worldpay\Api\Request\ApplePayPaymentService\Submit\Authorisation\Order;

use Inviqa\Worldpay\Api\Request\ApplePayPaymentService\Submit\Authorisation\Order\PaymentDetails\ApplePaySSL;
use Inviqa\Worldpay\Api\XmlNodeDefaults;

class PaymentDetails extends XmlNodeDefaults
{
    private $applePaySSL;

    public function __construct(
        ApplePaySSL $applePaySSL
    ) {
        $this->applePaySSL = $applePaySSL;
    }

    public function xmlChildren()
    {
        return [
            $this->applePaySSL
        ];
    }
}
