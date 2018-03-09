<?php

namespace Inviqa\Worldpay\Api\Request;

use Inviqa\Worldpay\Api\Request\PaymentService\MerchantCode;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\ThreeDS\Order\Info3DSecure;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\ThreeDS\Order\Session;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\ThreeDS\ThreeDSOrder;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\ThreeDS\Order\OrderCode;
use Inviqa\Worldpay\Api\Request\PaymentService\Version;

class ThreeDSRequestFactory
{
    private $defaultParameters = [
        'version' => "1.4",
        'orderCode' => "",
        'paResponse'=> "",
        'sessionId' => "",
    ];

    /**
     * @param $parameters
     * @return PaymentService
     * @throws \Inviqa\Worldpay\Api\Exception\InvalidRequestParameterException
     */
    public function buildFromRequestParameters($parameters)
    {
        $parameters += $this->defaultParameters;

        $orderCode = new OrderCode($parameters['orderCode']);
        $session = new Session(
            new Session\Id($parameters['sessionId'])
        );
        $info3DSecure = new Info3DSecure(
            new Info3DSecure\PaResponse($parameters['paResponse'])
        );

        $order = new ThreeDSOrder(
            $orderCode,
            $info3DSecure,
            $session
        );
        $paymentService = new PaymentService(
            new Version($parameters['version']),
            new MerchantCode($parameters['merchantCode']),
            new Submit($order)
        );

        return $paymentService;
    }
}
