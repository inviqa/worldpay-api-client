<?php

namespace Inviqa\Worldpay\Api\Request;

use Inviqa\Worldpay\Api\Request\PaymentService\MerchantCode;
use Inviqa\Worldpay\Api\Request\PaymentService\Modify;
use Inviqa\Worldpay\Api\Request\PaymentService\Modify\OrderModification\Cancel\Cancel;
use Inviqa\Worldpay\Api\Request\PaymentService\Modify\OrderModification\CancelModification;
use Inviqa\Worldpay\Api\Request\PaymentService\Modify\OrderModification\OrderCode;
use Inviqa\Worldpay\Api\Request\PaymentService\Version;

class CancelRequestFactory
{
    private $defaultParameters = [
        'version'          => "1.4",
        'orderCode'        => "",
    ];

    public function buildFromRequestParameters(array $parameters): PaymentService
    {
        $parameters += $this->defaultParameters;

        $orderCode          = new OrderCode($parameters['orderCode']);
        $cancel             = new Cancel();
        $cancelModification = new CancelModification($orderCode, $cancel);

        $paymentService = new PaymentService(
            new Version("1.4"),
            new MerchantCode($parameters['merchantCode']),
            new Modify($cancelModification)
        );

        return $paymentService;
    }
}
