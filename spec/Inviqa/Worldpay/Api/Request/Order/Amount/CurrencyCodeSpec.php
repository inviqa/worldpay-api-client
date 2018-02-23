<?php

namespace spec\Inviqa\Worldpay\Api\Request\Order\Amount;

use Inviqa\Worldpay\Api\Request\Order\Amount\CurrencyCode;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CurrencyCodeSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(CurrencyCode::class);
    }
}
