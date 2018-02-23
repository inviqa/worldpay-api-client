<?php

namespace spec\Inviqa\Worldpay\Api\Request\Order;

use Inviqa\Worldpay\Api\Request\Order\OrderCode;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class OrderCodeSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(OrderCode::class);
    }
}
