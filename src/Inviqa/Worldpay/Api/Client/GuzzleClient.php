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
        $response = $this->client->post("", [
            "body" => $xml,
            "headers" => [
                "content-type" => "application/xml",
            ],
        ]);

        return $response->getBody()->getContents();
    }
}
