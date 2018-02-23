<?php

namespace Inviqa\Worldpay\Api\Request\Order;

use Inviqa\Worldpay\Api\Request\Order\Amount\CurrencyCode;
use Inviqa\Worldpay\Api\Request\Order\Amount\Exponent;
use Inviqa\Worldpay\Api\Request\Order\Amount\Value;

class Amount
{
    private $currencyCode;
    private $exponent;
    private $value;

    public function __construct(
        CurrencyCode $currencyCode,
        Exponent $exponent,
        Value $value
    ) {
        $this->currencyCode = $currencyCode;
        $this->exponent = $exponent;
        $this->value = $value;
    }
}
