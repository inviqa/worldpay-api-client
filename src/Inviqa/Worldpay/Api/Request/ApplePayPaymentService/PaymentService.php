<?php

namespace Inviqa\Worldpay\Api\Request\ApplePayPaymentService;

use Inviqa\Worldpay\Api\XmlNodeDefaults;

class PaymentService extends XmlNodeDefaults
{
    private $version;
    private $merchantCode;
    private $paymentServiceType;

    public function __construct(
        Version $version,
        MerchantCode $merchantCode,
        PaymentServiceType $paymentServiceType
    ) {
        $this->version = $version;
        $this->merchantCode = $merchantCode;
        $this->paymentServiceType = $paymentServiceType;
    }

    public function xmlChildren()
    {
        return [
            $this->version,
            $this->merchantCode,
            $this->paymentServiceType,
        ];
    }
}
