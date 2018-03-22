<?php

namespace spec\Inviqa\Worldpay\Api\Request;

use PhpSpec\ObjectBehavior;
use Services\RefundFactory;

class RefundRequestFactorySpec extends ObjectBehavior
{
    function it_converts_a_list_of_parameters_into_a_refund_payment_service_instance()
    {
        $this->buildFromRequestParameters(
            RefundFactory::refundRequestParameters()
        )->shouldBeLike(RefundFactory::refundPaymentService());
    }
}
