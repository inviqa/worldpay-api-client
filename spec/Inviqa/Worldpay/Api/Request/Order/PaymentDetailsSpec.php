<?php

namespace spec\Inviqa\Worldpay\Api\Request\Order;

use Inviqa\Worldpay\Api\Request\Order\PaymentDetails;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PaymentDetailsSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(PaymentDetails::class);
    }
}
