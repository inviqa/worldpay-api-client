<?php

namespace spec\Inviqa\Worldpay\Api\Request\Order;

use Inviqa\Worldpay\Api\Request\Order\Amount;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AmountSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Amount::class);
    }
}
