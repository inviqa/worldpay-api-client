<?php

namespace spec\Inviqa\Worldpay\Api\Request\Order\PaymentDetails;

use Inviqa\Worldpay\Api\Request\Order\PaymentDetails\Session;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SessionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Session::class);
    }
}
