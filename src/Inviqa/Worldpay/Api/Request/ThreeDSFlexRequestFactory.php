<?php

namespace Inviqa\Worldpay\Api\Request;

use Inviqa\Worldpay\Api\Request\PaymentService\MerchantCode;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\ThreeDS\Order\Info3DSFlex\CompletedAuthentication;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\ThreeDS\Order\Session;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\ThreeDS\Order\OrderCode;
use Inviqa\Worldpay\Api\Request\PaymentService\Version;

class ThreeDSFlexRequestFactory
{
    private $defaultParameters = [
        'version' => "1.4",
        'orderCode' => "",
        'sessionId' => "",
    ];

    /**
     * @param $parameters
     * @return PaymentService
     * @throws \Inviqa\Worldpay\Api\Exception\InvalidRequestParameterException
     */
    public function buildFromRequestParameters(array $parameters): PaymentService
    {
        $parameters += $this->defaultParameters;

        $orderCode = new OrderCode($parameters['orderCode']);
        $session = new Session(
            new Session\Id($parameters['sessionId'])
        );
        $info3DSFlex = new PaymentService\Submit\ThreeDS\Order\Info3DSFlex(
            new CompletedAuthentication()
        );

        $order = new Submit\ThreeDS\ThreeDSFlexOrder(
            $orderCode,
            $info3DSFlex,
            $session
        );

        if (empty($parameters['merchantCode'])) {
            throw new \InvalidArgumentException('Merchande code must be defined');
        }

        $paymentService = new PaymentService(
            new Version($parameters['version']),
            new MerchantCode($parameters['merchantCode']),
            new Submit($order)
        );

        return $paymentService;
    }
}
