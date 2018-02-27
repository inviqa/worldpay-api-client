<?php

namespace spec\Inviqa\Worldpay\Api\Response;

use Inviqa\Worldpay\Api\Response\AuthorisedResponse;
use Inviqa\Worldpay\Api\Response\PaymentService\Reply\OrderStatus\OrderCode;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AuthorisedResponseSpec extends ObjectBehavior
{
    const XML = "<reply><orderStatus orderCode=\"order-reiss-test-123\"><lastEvent>AUTHORISED</lastEvent></orderStatus></reply>";

    function it_returns_the_response_details_when_the_last_event_is_authorised()
    {
        $this->beConstructedWith(self::XML);

        $this->isSuccessful()->shouldReturn(true);
        $this->rawXml()->shouldReturn(self::XML);
        $this->orderCode()->shouldBeLike(new OrderCode("order-reiss-test-123"));
    }
}
