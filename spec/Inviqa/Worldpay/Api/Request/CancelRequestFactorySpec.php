<?php

namespace spec\Inviqa\Worldpay\Api\Request;

use PhpSpec\ObjectBehavior;
use Services\CancelFactory;
use Services\RefundFactory;

class CancelRequestFactorySpec extends ObjectBehavior
{
    function it_converts_a_list_of_parameters_into_a_cancel_payment_service_instance()
    {
        $this->buildFromRequestParameters(
            CancelFactory::cancelRequestParameters()
        )->shouldBeLike(CancelFactory::cancelPaymentService());
    }
}
