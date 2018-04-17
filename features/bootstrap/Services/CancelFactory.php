<?php

namespace Services;

use Inviqa\Worldpay\Api\Request\PaymentService;
use Inviqa\Worldpay\Api\Request\PaymentService\MerchantCode;
use Inviqa\Worldpay\Api\Request\PaymentService\Modify;
use Inviqa\Worldpay\Api\Request\PaymentService\Modify\OrderModification\Cancel\Cancel;
use Inviqa\Worldpay\Api\Request\PaymentService\Modify\OrderModification\CancelModification;
use Inviqa\Worldpay\Api\Request\PaymentService\Modify\OrderModification\OrderCode;
use Inviqa\Worldpay\Api\Request\PaymentService\Version;
use Inviqa\Worldpay\Api\XmlConvertibleNode;

class CancelFactory
{
    public static function cancelPaymentService(): XmlConvertibleNode
    {
        $orderCode          = new OrderCode("order-ecomm-test-03");
        $cancel             = new Cancel();
        $cancelModification = new CancelModification($orderCode, $cancel);

        $paymentService = new PaymentService(
            new Version("1.4"),
            new MerchantCode("SESSIONECOM"),
            new Modify($cancelModification)
        );

        return $paymentService;
    }

    public static function simpleCsePaymentServiceRequestXml(): string
    {
        $xml = <<<XML
<paymentService version="1.4" merchantCode="SESSIONECOM">
  <modify>
    <orderModification orderCode="order-ecomm-test-03">
        <cancel/>
    </orderModification>
  </modify>
</paymentService>
XML;

        $strippedXml = preg_replace('/\s+/', '', $xml);

        return $strippedXml;
    }

    public static function cancelRequestParameters(): array
    {
        return [
            'orderCode'        => 'order-ecomm-test-03',
            'merchantCode'     => 'SESSIONECOM',
        ];
    }

    public static function cseCancelResponseXmlForOrderCode($orderCode)
    {
        $xml = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE paymentService PUBLIC "-//WorldPay//DTD WorldPay PaymentService v1//EN"
                                "http://dtd.worldpay.com/paymentService_v1.dtd">
<paymentService version="1.4" merchantCode="SESSIONECOM">
    <reply>
        <ok>
            <cancelReceived orderCode="$orderCode">
        </ok>
    </reply>
</paymentService>
XML;

        return $xml;
    }
}

