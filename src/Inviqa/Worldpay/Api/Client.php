<?php

namespace Inviqa\Worldpay\Api;

interface Client
{
    /**
     * @param string $xml
     * @throws \Exception
     *
     * @return mixed
     */
    public function sendAuthorizationRequest(string $xml);
}
