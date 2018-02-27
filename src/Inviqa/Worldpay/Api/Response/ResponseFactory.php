<?php

namespace Inviqa\Worldpay\Api\Response;

class ResponseFactory
{
    public static function responseFromXml(string $xml): AuthorisedResponse
    {
        return new AuthorisedResponse($xml);
    }
}
