<?php

namespace spec\Inviqa\Worldpay\Api\Request;

use PhpSpec\ObjectBehavior;
use Services\ThreeDSOrderFactory;

class ThreeDSRequestFactorySpec extends ObjectBehavior
{
    function it_converts_a_list_of_parameters_into_a_payment_service_instance()
    {
        $this->buildFromRequestParameters(
            ThreeDSOrderFactory::simpleCseThreeDSRequestParameters()
        )->shouldBeLike(ThreeDSOrderFactory::simpleCSEThreeDSPaymentService());
    }
}
