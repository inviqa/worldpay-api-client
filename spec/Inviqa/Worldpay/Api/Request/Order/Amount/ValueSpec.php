<?php

namespace spec\Inviqa\Worldpay\Api\Request\Order\Amount;

use Inviqa\Worldpay\Api\Request\Order\Amount\Value;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ValueSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Value::class);
    }
}
