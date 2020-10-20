<?php

namespace Inviqa\Worldpay\Api\Request;

use Inviqa\Worldpay\Api\Exception\InvalidRequestParameterException;
use Inviqa\Worldpay\Api\Request\PaymentService\MerchantCode;
use Inviqa\Worldpay\Api\Request\PaymentService\Modify;
use Inviqa\Worldpay\Api\Request\PaymentService\Modify\OrderModification\CancelOrRefund\Amount;
use Inviqa\Worldpay\Api\Request\PaymentService\Modify\OrderModification\CancelOrRefund\Amount\CurrencyCode;
use Inviqa\Worldpay\Api\Request\PaymentService\Modify\OrderModification\CancelOrRefund\Amount\DebitCreditIndicator;
use Inviqa\Worldpay\Api\Request\PaymentService\Modify\OrderModification\CancelOrRefund\Amount\Exponent;
use Inviqa\Worldpay\Api\Request\PaymentService\Modify\OrderModification\CancelOrRefund\Amount\Value;
use Inviqa\Worldpay\Api\Request\PaymentService\Modify\OrderModification\CancelOrRefund\CancelOrRefund;
use Inviqa\Worldpay\Api\Request\PaymentService\Modify\OrderModification\CancelOrRefund\Reference;
use Inviqa\Worldpay\Api\Request\PaymentService\Modify\OrderModification\CancelOrRefundModification;
use Inviqa\Worldpay\Api\Request\PaymentService\Modify\OrderModification\OrderCode;
use Inviqa\Worldpay\Api\Request\PaymentService\Version;

class CancelOrRefundRequestFactory
{
    private $defaultParameters = [
        'version'          => '1.4',
        'orderCode'        => '',
        'currencyCode'     => '',
        'exponent'         => '2',
        'amount'           => '',
        'debitCreditValue' => '',
        'reference'        => '',
    ];

    /**
     * @param array $parameters
     *
     * @return PaymentService
     *
     * @throws InvalidRequestParameterException
     */
    public function buildFromRequestParameters(array $parameters): PaymentService
    {
        $parameters += $this->defaultParameters;

        $cancelModification = new CancelOrRefundModification(
            new OrderCode($parameters['orderCode']),
            new CancelOrRefund(
                new Reference($parameters['reference']),
                new Amount(
                    new CurrencyCode($parameters['currencyCode']),
                    new DebitCreditIndicator('credit'),
                    new Exponent($parameters['exponent']),
                    new Value($parameters['amount'])
                )
            )
        );

        $paymentService = new PaymentService(
            new Version($parameters['version']),
            new MerchantCode($parameters['merchantCode']),
            new Modify($cancelModification)
        );

        return $paymentService;
    }
}
