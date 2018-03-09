<?php

namespace Services;

use Inviqa\Worldpay\Api\Client;
use Inviqa\Worldpay\Api\Client\HttpResponse;

class FakeClient implements Client
{
    public function sendRequest(string $xml, string $cookie = null)
    {
        if (strstr($xml, "trigger-an-error") !== FALSE) {
            return HttpResponse::fromContentAndCookie(
                OrderFactory::cseResponseXmlWithError(
                    "5",
                    "An internal CSE service error has occurred."
                )
            );
        }

        $orderCode = $this->nodeAttributeValueFromXml("order", "orderCode", $xml);

        if (strstr($xml, "trigger-3ds") !== FALSE) {
            return HttpResponse::fromContentAndCookie(OrderFactory::cse3DSResponseXMl($orderCode));
        }

        return HttpResponse::fromContentAndCookie(
            OrderFactory::cseResponseXmlForOrderCode($orderCode),
            "machine:123"
        );
    }

    private function nodeAttributeValueFromXml(string $node, string $attr, string $xml): string
    {
        if (preg_match("~<$node.*$attr=['\"]([^'\"]*)['\"]/?>~", $xml, $matches)) {
            return $matches[1];
        }

        return '';
    }
}
