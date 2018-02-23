<?php

namespace spec\Inviqa\Worldpay\Api\Request\Order\PaymentDetails\CseData\CardAddress\Address;

use Inviqa\Worldpay\Api\Request\Order\PaymentDetails\CseData\CardAddress\Address\City;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CitySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(City::class);
    }
}
