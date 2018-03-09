<?php

namespace Inviqa\Worldpay\Api;

use Inviqa\Worldpay\Api\Client\HttpResponse;

interface Client
{
    /**
     * @param string $xml
     * @param string|null $cookie
     *
     * @return HttpResponse
     *
     * @throws \Exception
     */
    public function sendRequest(string $xml, string $cookie = null);
}
