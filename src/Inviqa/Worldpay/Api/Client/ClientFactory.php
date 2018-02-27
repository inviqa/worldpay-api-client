<?php

namespace Inviqa\Worldpay\Api\Client;

use GuzzleHttp\Client as GuzzleHttpClient;
use Inviqa\Worldpay\Config;
use Services\FakeClient;

class ClientFactory
{
    private $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function getClient()
    {
        if ($this->config->isTestMode()) {
            return new FakeClient();
        }

        return new GuzzleClient(
            new GuzzleHttpClient()
        );
    }
}
