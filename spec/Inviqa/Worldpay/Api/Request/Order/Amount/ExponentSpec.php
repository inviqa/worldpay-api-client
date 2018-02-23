<?php

namespace spec\Inviqa\Worldpay\Api\Request\Order\Amount;

use Inviqa\Worldpay\Api\Request\Order\Amount\Exponent;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ExponentSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Exponent::class);
    }
}
