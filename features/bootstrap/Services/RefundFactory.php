<?php

namespace Services;

use Inviqa\Worldpay\Api\Request\PaymentService;
use Inviqa\Worldpay\Api\Request\PaymentService\MerchantCode;
use Inviqa\Worldpay\Api\Request\PaymentService\Modify;
use Inviqa\Worldpay\Api\Request\PaymentService\Modify\OrderModification\OrderCode;
use Inviqa\Worldpay\Api\Request\PaymentService\Modify\OrderModification\Refund\Amount;
use Inviqa\Worldpay\Api\Request\PaymentService\Modify\OrderModification\Refund\Amount\CurrencyCode;
use Inviqa\Worldpay\Api\Request\PaymentService\Modify\OrderModification\Refund\Amount\DebitCreditIndicator;
use Inviqa\Worldpay\Api\Request\PaymentService\Modify\OrderModification\Refund\Amount\Exponent;
use Inviqa\Worldpay\Api\Request\PaymentService\Modify\OrderModification\Refund\Amount\Value;
use Inviqa\Worldpay\Api\Request\PaymentService\Modify\OrderModification\Refund\Reference;
use Inviqa\Worldpay\Api\Request\PaymentService\Modify\OrderModification\Refund\Refund;
use Inviqa\Worldpay\Api\Request\PaymentService\Modify\OrderModification\RefundModification;
use Inviqa\Worldpay\Api\Request\PaymentService\Version;
use Inviqa\Worldpay\Api\XmlConvertibleNode;

class RefundFactory
{
    public static function refundPaymentService(): XmlConvertibleNode
    {
        $amount = new Amount(
            new CurrencyCode("GBP"),
            new DebitCreditIndicator('credit'),
            new Exponent("2"),
            new Value("1500")
        );

        $orderCode          = new OrderCode("order-ecomm-test-03");
        $reference          = new Reference('Manually refunded by tim.webster@inviqa.com (User ID: 2525)');
        $refund             = new Refund($reference, $amount);
        $refundModification = new RefundModification($orderCode, $refund);

        $paymentService = new PaymentService(
            new Version("1.4"),
            new MerchantCode("SESSIONECOM"),
            new Modify($refundModification)
        );

        return $paymentService;
    }

    public static function simpleCsePaymentServiceRequestXml(): string
    {
        $xml = <<<XML
<paymentService version="1.4" merchantCode="SESSIONECOM">
  <modify>
    <orderModification orderCode="order-ecomm-test-03">
        <refund>
              <amount currencyCode="GBP" exponent="2" value="1500" debitCreditValue="credit"/>
        </refund>
    </orderModification>
  </modify>
</paymentService>
XML;

        $strippedXml = preg_replace('/\s+/', '', $xml);

        return $strippedXml;
    }

    public static function refundRequestParameters(): array
    {
        return [
            'merchantCode'     => 'SESSIONECOM',
            'orderCode'        => 'order-ecomm-test-03',
            'currencyCode'     => 'GBP',
            'amount'           => '1500',
            'debitCreditValue' => 'credit',
            'exponent'         => '2',
            'reference'        => 'Manually refunded by tim.webster@inviqa.com (User ID: 2525)'
        ];
    }

    public static function cseRefundResponseXmlForOrderCode($orderCode)
    {
        $xml = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE paymentService PUBLIC "-//WorldPay//DTD WorldPay PaymentService v1//EN"
                                "http://dtd.worldpay.com/paymentService_v1.dtd">
<paymentService version="1.4" merchantCode="SESSIONECOM">
    <reply>
        <ok>
            <refundReceived orderCode="$orderCode">
                <amount value="10965" currencyCode="EUR" exponent="2" debitCreditIndicator="credit"/>
            </refundReceived>
        </ok>
    </reply>
</paymentService>
XML;

        return $xml;
    }
}

