<?php

namespace spec\Inviqa\Worldpay\Api\Request\Order\PaymentDetails\CseData;

use Inviqa\Worldpay\Api\Request\Order\PaymentDetails\CseData\EncryptedData;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class EncryptedDataSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(EncryptedData::class);
    }
}
