<?php

namespace Inviqa\Worldpay\Api\Request;

use Inviqa\Worldpay\Api\Request\PaymentService\MerchantCode;
use Inviqa\Worldpay\Api\Request\PaymentService\Modify;
use Inviqa\Worldpay\Api\Request\PaymentService\Modify\OrderModification\Capture\Amount;
use Inviqa\Worldpay\Api\Request\PaymentService\Modify\OrderModification\Capture\Amount\CurrencyCode;
use Inviqa\Worldpay\Api\Request\PaymentService\Modify\OrderModification\Capture\Amount\DebitCreditIndicator;
use Inviqa\Worldpay\Api\Request\PaymentService\Modify\OrderModification\Capture\Amount\Exponent;
use Inviqa\Worldpay\Api\Request\PaymentService\Modify\OrderModification\Capture\Amount\Value;
use Inviqa\Worldpay\Api\Request\PaymentService\Modify\OrderModification\Capture\Capture;
use Inviqa\Worldpay\Api\Request\PaymentService\Modify\OrderModification\CaptureModification;
use Inviqa\Worldpay\Api\Request\PaymentService\Modify\OrderModification\OrderCode;
use Inviqa\Worldpay\Api\Request\PaymentService\Version;

class CaptureRequestFactory
{
    private $defaultParameters = [
        'version' => "1.4",
        'orderCode' => "",
        'currencyCode' => "",
        'exponent' => "2",
        'amount' => "",
        'debitCreditValue' => "",
    ];

    public function buildFromRequestParameters(array $parameters): PaymentService
    {
        $parameters += $this->defaultParameters;

        $amount = new Amount(
            new CurrencyCode($parameters['currencyCode']),
            new DebitCreditIndicator('credit'),
            new Exponent("2"),
            new Value($parameters['amount'])
        );

        $orderCode           = new OrderCode($parameters['orderCode']);
        $capture             = new Capture($amount);
        $captureModification = new CaptureModification($orderCode, $capture);

        $paymentService = new PaymentService(
            new Version("1.4"),
            new MerchantCode($parameters['merchantCode']),
            new Modify($captureModification)
        );

        return $paymentService;
    }
}
