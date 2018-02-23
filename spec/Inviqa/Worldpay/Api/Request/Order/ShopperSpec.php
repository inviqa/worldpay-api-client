<?php

namespace spec\Inviqa\Worldpay\Api\Request\Order;

use Inviqa\Worldpay\Api\Request\Order\Shopper;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ShopperSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Shopper::class);
    }
}
