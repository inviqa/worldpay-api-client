<?php

namespace spec\Inviqa\Worldpay\Api\Request;

use PhpSpec\ObjectBehavior;
use Services\OrderFactory;

class AuthorizeRequestFactorySpec extends ObjectBehavior
{
    function it_converts_a_list_of_parameters_into_a_payment_service_instance()
    {
        $this->buildFromRequestParameters(
            OrderFactory::simpleCseRequestParameters()
        )->shouldBeLike(OrderFactory::simpleCsePaymentService());
    }

    function it_converts_a_list_of_parameters_into_a_high_risk_payment_service_instance()
    {
        $this->buildFromRequestParameters(
            OrderFactory::simpleCseRequestParametersWithHighRisk()
        )->shouldBeLike(OrderFactory::simpleCsePaymentServiceWithHighRisk());
    }
}
