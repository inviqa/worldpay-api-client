<?php

namespace Services;

use Inviqa\Worldpay\Api\Request\PaymentService;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\ThreeDS\Order\Info3DSecure;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\ThreeDS\Order\OrderCode;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\ThreeDS\Order\Session;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\ThreeDS\ThreeDSOrder;
use Inviqa\Worldpay\Api\Request\PaymentService\Version;
use Inviqa\Worldpay\Api\Request\PaymentService\MerchantCode;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit;
use Inviqa\Worldpay\Api\XmlConvertibleNode;

class ThreeDSOrderFactory
{
    public static function simpleCSEThreeDSPaymentService(): XmlConvertibleNode
    {
        $orderCode = new OrderCode("order-ecomm-test-03");
        $info3DSecure = new Info3DSecure(
          new Info3DSecure\PaResponse('someparesponse')
        );
        $session = new Session(
            new Session\Id("0215ui8ib1")
        );
        $order = new ThreeDSOrder(
            $orderCode,
            $info3DSecure,
            $session
        );
        $paymentService = new PaymentService(
            new Version("1.4"),
            new MerchantCode("SESSIONECOM"),
            new Submit($order)
        );

        return $paymentService;
    }

    public static function simpleCseThreeDSRequestParameters(): array
    {
        return [
            'merchantCode' => 'SESSIONECOM',
            'orderCode'    => 'order-ecomm-test-03',
            'sessionId'    => '0215ui8ib1',
            'paResponse'   => 'someparesponse'
        ];
    }
}
