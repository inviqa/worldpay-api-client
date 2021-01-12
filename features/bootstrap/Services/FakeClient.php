<?php

namespace Services;

use Inviqa\Worldpay\Api\Client;
use Inviqa\Worldpay\Api\Client\HttpResponse;

class FakeClient implements Client
{
    /**
     * @var bool
     */
    private static $isCardDetailsEnabled = false;

    public function sendRequest(string $xml, string $cookie = null)
    {
        if (strstr($xml, "trigger-an-error") !== false) {
            return HttpResponse::fromContentAndCookie(
                OrderFactory::cseResponseXmlWithError(
                    "5",
                    "An internal CSE service error has occurred."
                )
            );
        }

        if (strstr($xml, "trigger-refused-event") !== false) {
            return HttpResponse::fromContentAndCookie(
                OrderFactory::cseResponseXmlWithRefusedError()
            );
        }

        $orderCode = $this->nodeAttributeValueFromXml("order", "orderCode", $xml);

        if (strstr($xml, 'dynamic3DS overrideAdvice="do3DS"') !== false) {
            return HttpResponse::fromContentAndCookie(OrderFactory::cse3DSResponseXMl($orderCode));
        }

        if (strstr($xml, '3ds_flex_challenge_required"') !== false) {
            return HttpResponse::fromContentAndCookie(OrderFactory::cse3DSFlexResponseXMl($orderCode));
        }

        if (strstr($xml, "<capture>") !== false || preg_match('/<capture reference="\d+">/', $xml) === 1) {
            return HttpResponse::fromContentAndCookie(
                CaptureFactory::cseCaptureResponseXmlForOrderCode($orderCode),
                "machine:123"
            );
        }

        if (strstr($xml, "<refund>") !== false || preg_match('/<refund reference="\d+">/', $xml) === 1) {
            return HttpResponse::fromContentAndCookie(
                RefundFactory::cseRefundResponseXmlForOrderCode($orderCode),
                "machine:123"
            );
        }

        if (strstr($xml, "</cancel>") !== false) {
            return HttpResponse::fromContentAndCookie(
                CancelFactory::cseCancelResponseXmlForOrderCode($orderCode),
                "machine:123"
            );
        }

        if (strstr($xml, "</cancelOrRefund>") !== false) {
            return HttpResponse::fromContentAndCookie(
                CancelOrRefundFactory::cseCancelOrRefundResponseXmlForOrderCode($orderCode),
                "machine:123"
            );
        }

        if (self::$isCardDetailsEnabled) {
            return HttpResponse::fromContentAndCookie(
                OrderFactory::cseResponseXmlForOrderCode($orderCode),
                "machine:123"
            );
        }

        return HttpResponse::fromContentAndCookie(
            OrderFactory::cseResponseXmlForOrderCode($orderCode),
            "machine:123"
        );
    }

    public static function enableCardDetails()
    {
        self::$isCardDetailsEnabled = true;
    }

    private function nodeAttributeValueFromXml(string $node, string $attr, string $xml): string
    {
        if (preg_match("~<$node.*$attr=['\"]([^'\"]*)['\"]/?>~", $xml, $matches)) {
            return $matches[1];
        }

        return '';
    }
}
