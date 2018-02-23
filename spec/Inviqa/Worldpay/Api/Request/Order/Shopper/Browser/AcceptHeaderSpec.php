<?php

namespace spec\Inviqa\Worldpay\Api\Request\Order\Shopper\Browser;

use Inviqa\Worldpay\Api\Request\Order\Shopper\Browser\AcceptHeader;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AcceptHeaderSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(AcceptHeader::class);
    }
}
