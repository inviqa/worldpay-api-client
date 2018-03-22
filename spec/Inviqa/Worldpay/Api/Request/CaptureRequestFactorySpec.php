<?php

namespace spec\Inviqa\Worldpay\Api\Request;

use PhpSpec\ObjectBehavior;
use Services\CaptureFactory;

class CaptureRequestFactorySpec extends ObjectBehavior
{
    function it_converts_a_list_of_parameters_into_a_capture_payment_service_instance()
    {
        $this->buildFromRequestParameters(
            CaptureFactory::captureRequestParameters()
        )->shouldBeLike(CaptureFactory::capturePaymentService());
    }
}
