<?php

namespace Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order;

use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\ApplePaySSL;
use Inviqa\Worldpay\Api\XmlNodeDefaults;

class PaymentDetailsApplePay extends XmlNodeDefaults implements PaymentDetails
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

    public function xmlLabel()
    {
        return 'paymentDetails';
    }
}
