<?php

namespace spec\Inviqa\Worldpay\Api\Request\Order\PaymentDetails\Session;

use Inviqa\Worldpay\Api\Request\Order\PaymentDetails\Session\ShopperIPAddress;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ShopperIPAddressSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ShopperIPAddress::class);
    }
}
