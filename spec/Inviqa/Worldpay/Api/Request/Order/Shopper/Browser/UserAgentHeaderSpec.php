<?php

namespace spec\Inviqa\Worldpay\Api\Request\Order\Shopper\Browser;

use Inviqa\Worldpay\Api\Request\Order\Shopper\Browser\UserAgentHeader;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UserAgentHeaderSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(UserAgentHeader::class);
    }
}
