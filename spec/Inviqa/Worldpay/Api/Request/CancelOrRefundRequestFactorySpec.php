<?php

namespace spec\Inviqa\Worldpay\Api\Request;

use PhpSpec\ObjectBehavior;
use Services\CancelOrRefundFactory;

class CancelOrRefundRequestFactorySpec extends ObjectBehavior
{
    function it_converts_a_list_of_parameters_into_a_cancel_or_refund_payment_service_instance()
    {
        $this->buildFromRequestParameters(
            CancelOrRefundFactory::cancelOrRefundRequestParameters()
        )->shouldBeLike(CancelOrRefundFactory::cancelOrRefundPaymentService());
    }
}
