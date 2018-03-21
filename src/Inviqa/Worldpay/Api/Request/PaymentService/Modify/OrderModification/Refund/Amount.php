<?php

namespace Inviqa\Worldpay\Api\Request\PaymentService\Modify\OrderModification\Refund;

use Inviqa\Worldpay\Api\Request\PaymentService\Modify\OrderModification\Refund\Amount\CurrencyCode;
use Inviqa\Worldpay\Api\Request\PaymentService\Modify\OrderModification\Refund\Amount\DebitCreditIndicator;
use Inviqa\Worldpay\Api\Request\PaymentService\Modify\OrderModification\Refund\Amount\Exponent;
use Inviqa\Worldpay\Api\Request\PaymentService\Modify\OrderModification\Refund\Amount\Value;
use Inviqa\Worldpay\Api\XmlNodeDefaults;

class Amount extends XmlNodeDefaults
{
    private $currencyCode;
    private $debitCreditIndicator;
    private $exponent;
    private $value;

    public function __construct(
        CurrencyCode $currencyCode,
        DebitCreditIndicator $debitCreditIndicator,
        Exponent $exponent,
        Value $value
    ) {
        $this->currencyCode = $currencyCode;
        $this->debitCreditIndicator = $debitCreditIndicator;
        $this->exponent = $exponent;
        $this->value = $value;
    }

    public function xmlChildren()
    {
        return [
            $this->currencyCode,
            $this->debitCreditIndicator,
            $this->exponent,
            $this->value
        ];
    }
}
