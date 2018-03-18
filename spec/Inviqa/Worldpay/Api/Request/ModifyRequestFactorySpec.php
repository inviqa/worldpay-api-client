<?php

namespace spec\Inviqa\Worldpay\Api\Request;

use PhpSpec\ObjectBehavior;
use Services\ModifyFactory;
use Services\OrderFactory;

class ModifyRequestFactorySpec extends ObjectBehavior
{
    function it_converts_a_list_of_parameters_into_a_capture_payment_service_instance()
    {
        $this->buildFromRequestParameters(
            ModifyFactory::captureRequestParameters()
        )->shouldBeLike(ModifyFactory::capturePaymentService());
    }
}
