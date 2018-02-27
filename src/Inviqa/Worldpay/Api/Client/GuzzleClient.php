<?php

namespace Inviqa\Worldpay\Api\Client;

use GuzzleHttp\Client as GuzzleHttpClient;
use Inviqa\Worldpay\Api\Client;

class GuzzleClient implements Client
{
    private $client;

    public function __construct(GuzzleHttpClient $client)
    {
        $this->client = $client;
    }

    public function sendAuthorizationRequest(string $xml)
    {
        // TODO: Implement sendAuthorizationRequest() method.
    }
}
