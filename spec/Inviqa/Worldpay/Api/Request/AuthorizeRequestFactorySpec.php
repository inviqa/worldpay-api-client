<?php

namespace spec\Inviqa\Worldpay\Api\Request;

use Inviqa\Worldpay\Config;
use PhpSpec\ObjectBehavior;
use Services\OrderFactory;

class AuthorizeRequestFactorySpec extends ObjectBehavior
{
    function it_converts_a_list_of_parameters_into_a_payment_service_instance(Config $config)
    {
        $this->beConstructedWith($config);

        $this->buildFromRequestParameters(
            OrderFactory::simpleCseRequestParameters()
        )->shouldBeLike(OrderFactory::simpleCsePaymentService());
    }
}
