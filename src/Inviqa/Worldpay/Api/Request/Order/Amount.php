<?php

namespace Inviqa\Worldpay\Api\Request\Order;

use Inviqa\Worldpay\Api\Request\Order\Amount\CurrencyCode;
use Inviqa\Worldpay\Api\Request\Order\Amount\Exponent;
use Inviqa\Worldpay\Api\Request\Order\Amount\Value;
use Inviqa\Worldpay\Api\XmlNodeDefaults;

class Amount extends XmlNodeDefaults
{
    private $currencyCode;
    private $exponent;
    private $value;

    public function __construct(
        CurrencyCode $currencyCode,
        Exponent $exponent,
        Value $value
    )
    {
        $this->currencyCode = $currencyCode;
        $this->exponent = $exponent;
        $this->value = $value;
    }

    public function xmlChildren()
    {
        return [
            $this->currencyCode,
            $this->exponent,
            $this->value,
        ];
    }
}
