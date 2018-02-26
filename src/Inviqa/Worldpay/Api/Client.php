<?php

namespace Inviqa\Worldpay\Api;

interface Client
{
    public function sendAuthorizationRequest(string $xml);
}
