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

    public function sendRequest(string $xml, string $cookie = null)
    {
        $headers = [
            "content-type" => "application/xml",
        ];

        if (!empty($cookie)){
            $headers['machine'] = $cookie;
        }

        $response = $this->client->post("", [
            "body" => $xml,
            "headers" => $headers
        ]);

        return $response->getBody()->getContents();
    }
}
