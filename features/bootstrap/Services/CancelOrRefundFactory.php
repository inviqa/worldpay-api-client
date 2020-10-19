<?php

namespace Services;

use Inviqa\Worldpay\Api\Request\PaymentService;
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
use Inviqa\Worldpay\Api\XmlConvertibleNode;

class CancelOrRefundFactory
{
    public static function cancelOrRefundRequestParameters(): array
    {
        return [
            'merchantCode'     => 'SESSIONECOM',
            'orderCode'        => 'order-ecomm-test-04',
            'currencyCode'     => 'GBP',
            'amount'           => '1500',
            'debitCreditValue' => 'credit',
            'exponent'         => '2',
            'reference'        => 'Manually refunded by zsolt.gal@inviqa.com (User ID: 4242)'
        ];
    }

    public static function cancelOrRefundPaymentService(): XmlConvertibleNode
    {
        $cancelModification = new CancelOrRefundModification(
            new OrderCode('order-ecomm-test-04'),
            new CancelOrRefund(
                new Reference('Manually refunded by zsolt.gal@inviqa.com (User ID: 4242)'),
                new Amount(
                    new CurrencyCode('GBP'),
                    new DebitCreditIndicator('credit'),
                    new Exponent('2'),
                    new Value('1500')
                )
            )
        );

        $paymentService = new PaymentService(
            new Version('1.4'),
            new MerchantCode('SESSIONECOM'),
            new Modify($cancelModification)
        );

        return $paymentService;
    }

    public static function cseCancelOrRefundResponseXmlForOrderCode($orderCode)
    {
        $xml = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE paymentService PUBLIC "-//WorldPay//DTD WorldPay PaymentService v1//EN"
                                "http://dtd.worldpay.com/paymentService_v1.dtd">
<paymentService version="1.4" merchantCode="SESSIONECOM">
    <reply>
        <ok>
            <voidReceived orderCode="$orderCode">
                <amount value="10965" currencyCode="EUR" exponent="2" debitCreditIndicator="credit"/>
            </voidReceived>
        </ok>
    </reply>
</paymentService>
XML;

        return $xml;
    }
}

