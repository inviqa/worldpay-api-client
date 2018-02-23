<?php

namespace spec\Inviqa\Worldpay\Api\Request\Order\PaymentDetails;

use Inviqa\Worldpay\Api\Request\Order\PaymentDetails\CseData;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CseDataSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(CseData::class);
    }
}
