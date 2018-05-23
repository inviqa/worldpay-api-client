<?php

namespace Inviqa\Worldpay\Api\Request;

use Inviqa\Worldpay\Api\Request\PaymentService\MerchantCode;
use Inviqa\Worldpay\Api\Request\PaymentService\Modify;
use Inviqa\Worldpay\Api\Request\PaymentService\Modify\OrderModification\OrderCode;
use Inviqa\Worldpay\Api\Request\PaymentService\Modify\OrderModification\Refund\Reference;
use Inviqa\Worldpay\Api\Request\PaymentService\Modify\OrderModification\Refund\Amount;
use Inviqa\Worldpay\Api\Request\PaymentService\Modify\OrderModification\Refund\Amount\CurrencyCode;
use Inviqa\Worldpay\Api\Request\PaymentService\Modify\OrderModification\Refund\Amount\DebitCreditIndicator;
use Inviqa\Worldpay\Api\Request\PaymentService\Modify\OrderModification\Refund\Amount\Exponent;
use Inviqa\Worldpay\Api\Request\PaymentService\Modify\OrderModification\Refund\Amount\Value;
use Inviqa\Worldpay\Api\Request\PaymentService\Modify\OrderModification\Refund\Refund;
use Inviqa\Worldpay\Api\Request\PaymentService\Modify\OrderModification\RefundModification;
use Inviqa\Worldpay\Api\Request\PaymentService\Version;

class RefundRequestFactory
{
    private $defaultParameters = [
        'version'          => "1.4",
        'orderCode'        => "",
        'currencyCode'     => "",
        'exponent'         => "2",
        'amount'           => "",
        'debitCreditValue' => "",
        'reference'        => "",
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

        $orderCode          = new OrderCode($parameters['orderCode']);
        $reference          = new Reference($parameters['reference']);
        $refund             = new Refund($reference, $amount);
        $refundModification = new RefundModification($orderCode, $refund);

        $paymentService = new PaymentService(
            new Version("1.4"),
            new MerchantCode($parameters['merchantCode']),
            new Modify($refundModification)
        );

        return $paymentService;
    }
}
