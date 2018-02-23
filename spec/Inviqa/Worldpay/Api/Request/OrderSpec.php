<?php

namespace spec\Inviqa\Worldpay\Api\Request;

use Inviqa\Worldpay\Api\Request\Order;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class OrderSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Order::class);
    }
}
