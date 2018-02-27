<?php

namespace spec\Inviqa\Worldpay\Api\Client;

use Inviqa\Worldpay\Api\Client\GuzzleClient;
use Inviqa\Worldpay\Config;
use PhpSpec\ObjectBehavior;
use Services\FakeClient;

class ClientFactorySpec extends ObjectBehavior
{
    function let(Config $config)
    {
        $this->beConstructedWith($config);
    }

    function it_returns_a_fake_client_when_test_mode_is_enabled(Config $config)
    {
        $config->isTestMode()->willReturn(true);

        $this->getClient()->shouldBeAnInstanceOf(FakeClient::class);
    }

    function it_returns_a_guzzle_client_when_test_mode_is_enabled(Config $config)
    {
        $config->isTestMode()->willReturn(false);
        $config->uri()->shouldBeCalled();
        $config->username()->shouldBeCalled();
        $config->password()->shouldBeCalled();

        $this->getClient()->shouldBeAnInstanceOf(GuzzleClient::class);
    }
}
