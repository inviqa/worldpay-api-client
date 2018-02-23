<?php

namespace spec\Inviqa\Worldpay\Api\Request\Order\PaymentDetails\CseData\CardAddress\Address;

use Inviqa\Worldpay\Api\Request\Order\PaymentDetails\CseData\CardAddress\Address\AddressOne;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AddressOneSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(AddressOne::class);
    }
}
