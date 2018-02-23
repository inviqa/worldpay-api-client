<?php

namespace spec\Inviqa\Worldpay\Api\Request\Order\PaymentDetails\CseData\CardAddress\Address;

use Inviqa\Worldpay\Api\Request\Order\PaymentDetails\CseData\CardAddress\Address\AddressThree;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AddressThreeSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(AddressThree::class);
    }
}
