<?php

namespace Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order;

use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\PayWithGoogleSSL;
use Inviqa\Worldpay\Api\XmlNodeDefaults;

class PaymentDetailsGooglePay extends XmlNodeDefaults implements PaymentDetails
{
    private $payWithGoogleSSL;

    public function __construct(
        PayWithGoogleSSL $payWithGoogleSSL
    ) {
        $this->payWithGoogleSSL = $payWithGoogleSSL;
    }

    public function xmlChildren()
    {
        return [
            $this->payWithGoogleSSL
        ];
    }

    public function xmlLabel()
    {
        return 'paymentDetails';
    }
}
