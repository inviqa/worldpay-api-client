<?php

namespace Services;


use Inviqa\Worldpay\Api\Request\PaymentService;
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
use Inviqa\Worldpay\Api\XmlConvertibleNode;

class ModifyFactory
{
    public static function capturePaymentService(): XmlConvertibleNode
    {
        $amount = new Amount(
            new CurrencyCode("GBP"),
            new DebitCreditIndicator('credit'),
            new Exponent("2"),
            new Value("1500")
        );

        $orderCode           = new OrderCode("order-ecomm-test-03");
        $capture             = new Capture($amount);
        $captureModification = new CaptureModification($orderCode, $capture);

        $paymentService = new PaymentService(
            new Version("1.4"),
            new MerchantCode("SESSIONECOM"),
            new Modify($captureModification)
        );

        return $paymentService;
    }

    public static function simpleCsePaymentServiceRequestXml(): string
    {
        $xml = <<<XML
<paymentService version="1.4" merchantCode="SESSIONECOM">
  <modify>
    <orderModification orderCode="order-ecomm-test-03">
        <capture>
              <amount currencyCode="GBP" exponent="2" value="1500" debitCreditValue="credit"/>
        </capture>
    </orderModification>
  </modify>
</paymentService>
XML;

        $strippedXml = preg_replace('/\s+/', '', $xml);

        return $strippedXml;
    }

    public static function captureRequestParameters(): array
    {
        return [
            'merchantCode'     => 'SESSIONECOM',
            'orderCode'        => 'order-ecomm-test-03',
            'currencyCode'     => 'GBP',
            'amount'           => '1500',
            'debitCreditValue' => 'credit',
            'exponent'         => '2'
        ];
    }

    public static function cseCaptureResponseXmlForOrderCode($orderCode)
    {
        $xml = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE paymentService PUBLIC "-//WorldPay//DTD WorldPay PaymentService v1//EN"
                                "http://dtd.worldpay.com/paymentService_v1.dtd">
<paymentService version="1.4" merchantCode="SESSIONECOM">
    <reply>
        <ok>
            <captureReceived orderCode="$orderCode">
                <amount value="10965" currencyCode="EUR" exponent="2" debitCreditIndicator="credit"/>
            </captureReceived>
        </ok>
    </reply>
</paymentService>
XML;

        return $xml;
    }
}

