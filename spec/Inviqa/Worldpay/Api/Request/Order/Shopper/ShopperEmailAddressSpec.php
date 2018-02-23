<?php

namespace spec\Inviqa\Worldpay\Api\Request\Order\Shopper;

use Inviqa\Worldpay\Api\Request\Order\Shopper\ShopperEmailAddress;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ShopperEmailAddressSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ShopperEmailAddress::class);
    }
}
