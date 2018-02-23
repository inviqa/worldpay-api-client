<?php

namespace spec\Inviqa\Worldpay\Api\Request\Order\PaymentDetails\CseData\CardAddress;

use Inviqa\Worldpay\Api\Request\Order\PaymentDetails\CseData\CardAddress\Address;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AddressSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Address::class);
    }
}
