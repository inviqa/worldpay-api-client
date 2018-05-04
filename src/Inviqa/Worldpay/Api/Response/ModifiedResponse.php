<?php

namespace Inviqa\Worldpay\Api\Response;

use Inviqa\Worldpay\Api\Client\HttpResponse;
use Inviqa\Worldpay\Api\Response\PaymentService\Reply\OrderStatus\OrderCode;

abstract class ModifiedResponse
{
    protected $machineCookie;
    protected $rawXml;
    protected $successful;
    protected $requestXml;

    public function __construct(HttpResponse $httpResponse, string $requestXml)
    {
        $this->rawXml = $httpResponse->content();
        $this->requestXml = $requestXml;
        $this->machineCookie = $httpResponse->cookie();
        $this->successful = false !== strpos($this->rawXml, "<ok>") ;
    }

    public function isSuccessful()
    {
        return $this->successful;
    }

    public function rawXml()
    {
        return $this->rawXml;
    }

    public function rawRequestXml()
    {
        return $this->requestXml;
    }

    public function machineCookie()
    {
        return $this->machineCookie;
    }

    abstract public function orderCode();

    protected function nodeAttributeValue(string $nodeName, string $attributeName): string
    {
        if (preg_match("~<$nodeName.*$attributeName=['\"]([^'\"]*)['\"]/?>~", $this->rawXml, $matches)) {
            return $matches[1];
        }

        return '';
    }
}
