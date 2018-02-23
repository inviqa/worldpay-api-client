<?php

namespace spec\Inviqa\Worldpay\Api\Request\Order\PaymentDetails\CseData;

use Inviqa\Worldpay\Api\Request\Order\PaymentDetails\CseData\CardAddress;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CardAddressSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(CardAddress::class);
    }
}
