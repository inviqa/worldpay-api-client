<?php

namespace Inviqa\Worldpay\Api;

interface Client
{
    /**
     * @param string $xml
     * @param string $cookie
     * @throws \Exception
     *
     * @return mixed
     */
    public function sendRequest(string $xml, string $cookie = null);
}
