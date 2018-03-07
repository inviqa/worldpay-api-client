<?php

namespace Inviqa\Worldpay\Api\Response;

use Inviqa\Worldpay\Api\Response\PaymentService\Reply\OrderStatus\OrderCode;

class AuthorisedResponse
{
    /**
     * @var string
     */
    private $rawXml;

    /**
     * @var bool
     */
    private $successful;

    /**
     * @var OrderCode
     */
    private $orderCode;

    public function __construct(string $xml)
    {
        $this->rawXml = $xml;
        $this->successful = $this->nodeValue("lastEvent") === "AUTHORISED";
        $this->orderCode = new OrderCode($this->nodeAttributeValue("orderStatus", "orderCode"));
    }

    private function nodeValue(string $nodeName): string
    {
        if (preg_match("~$nodeName>([^<]+)</$nodeName~", $this->rawXml, $matches)) {
            return $matches[1];
        }

        return '';
    }

    private function nodeAttributeValue(string $nodeName, string $attributeName): string
    {
        if (preg_match("~<$nodeName.*$attributeName=['\"]([^'\"]*)['\"]/?>~", $this->rawXml, $matches)) {
            return $matches[1];
        }

        return '';
    }

    public function isSuccessful(): bool
    {
        return $this->successful;
    }

    public function rawXml()
    {
        return $this->rawXml;
    }

    public function orderCode()
    {
        return $this->orderCode;
    }

    public function errorCode()
    {
        return $this->nodeAttributeValue("error", "code");
    }

    public function errorMessage()
    {
        return $this->nodeValueFromCData("error");
    }

    private function nodeValueFromCData(string $nodeName): string
    {
        if (preg_match("~${nodeName}[^>]*>\s*<!\[CDATA\[(.*?)\]\]>~", $this->rawXml, $matches)) {
            return $matches[1];
        }

        return '';
    }

    public function is3DSecure(): bool
    {
        return strstr($this->rawXml, "<request3DSecure>") !== false;
    }

    public function paRequestValue(): string
    {
        return $this->nodeValue("paRequest");
    }

    public function issuerURL(): string
    {
        return $this->nodeValueFromCData("issuerURL");
    }
}
