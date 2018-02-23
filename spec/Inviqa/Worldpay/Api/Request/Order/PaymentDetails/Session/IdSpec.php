<?php

namespace spec\Inviqa\Worldpay\Api\Request\Order\PaymentDetails\Session;

use Inviqa\Worldpay\Api\Request\Order\PaymentDetails\Session\Id;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class IdSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Id::class);
    }
}
