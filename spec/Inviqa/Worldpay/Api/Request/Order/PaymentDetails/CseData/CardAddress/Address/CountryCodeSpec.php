<?php

namespace spec\Inviqa\Worldpay\Api\Request\Order\PaymentDetails\CseData\CardAddress\Address;

use Inviqa\Worldpay\Api\Request\Order\PaymentDetails\CseData\CardAddress\Address\CountryCode;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CountryCodeSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(CountryCode::class);
    }
}
