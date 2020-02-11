<?php

namespace Inviqa\Worldpay\Api\Request\ApplePayPaymentService\Submit\Authorisation\Order;

use Inviqa\Worldpay\Api\Request\ApplePayPaymentService\Submit\Authorisation\Order\Amount\CurrencyCode;
use Inviqa\Worldpay\Api\Request\ApplePayPaymentService\Submit\Authorisation\Order\Amount\Exponent;
use Inviqa\Worldpay\Api\Request\ApplePayPaymentService\Submit\Authorisation\Order\Amount\Value;
use Inviqa\Worldpay\Api\XmlNodeDefaults;

class Amount extends XmlNodeDefaults
{
    private $currencyCode;
    private $exponent;
    private $value;

    public function __construct(
        Value $value,
        CurrencyCode $currencyCode,
        Exponent $exponent
    ){
        $this->value = $value;
        $this->currencyCode = $currencyCode;
        $this->exponent = $exponent;
    }

    public function xmlChildren()
    {
        return [
            $this->value,
            $this->currencyCode,
            $this->exponent,
        ];
    }
}
