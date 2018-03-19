<?php

namespace Inviqa\Worldpay\Api\Response;

use Inviqa\Worldpay\Api\Client\HttpResponse;
use Inviqa\Worldpay\Api\Response\PaymentService\Reply\OrderStatus\OrderCode;

abstract class ModifiedResponse
{
    protected $machineCookie;
    protected $rawXml;
    protected $successful;

    /**
     * @param HttpResponse $httpResponse
     */
    public function __construct(HttpResponse $httpResponse)
    {
        $this->rawXml = $httpResponse->content();
        $this->machineCookie = $httpResponse->cookie();
        $this->successful = false !== strpos($this->rawXml, "<ok>") ;
    }

    abstract public function orderCode();

    public function isSuccessful()
    {
        return $this->successful;
    }

    public function rawXml()
    {
        return $this->rawXml;
    }

    public function machineCookie()
    {
        return $this->machineCookie;
    }

    protected function nodeAttributeValue(string $nodeName, string $attributeName): string
    {
        if (preg_match("~<$nodeName.*$attributeName=['\"]([^'\"]*)['\"]/?>~", $this->rawXml, $matches)) {
            return $matches[1];
        }

        return '';
    }
}
