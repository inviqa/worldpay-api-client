<?php

namespace spec\Inviqa\Worldpay\Api\Request\Order\Shopper;

use Inviqa\Worldpay\Api\Request\Order\Shopper\Browser;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BrowserSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Browser::class);
    }
}
