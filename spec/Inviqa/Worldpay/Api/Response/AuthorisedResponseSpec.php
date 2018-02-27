<?php

namespace spec\Inviqa\Worldpay\Api\Response;

use Inviqa\Worldpay\Api\Response\AuthorisedResponse;
use Inviqa\Worldpay\Api\Response\PaymentService\Reply\OrderStatus\OrderCode;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AuthorisedResponseSpec extends ObjectBehavior
{
    const XML = "<reply><orderStatus orderCode=\"order-reiss-test-123\"><lastEvent>AUTHORISED</lastEvent></orderStatus></reply>";
    const ERROR_XML = "<reply><error code=\"" . self::ERROR_CODE . "\"><![CDATA[" . self::ERROR_MSG . "]]></error></reply>";
    const ERROR_MSG = "An internal CSE service error has occurred.";
    const ERROR_CODE = "5";

    function it_returns_the_response_details_when_the_last_event_is_authorised()
    {
        $this->beConstructedWith(self::XML);

        $this->isSuccessful()->shouldReturn(true);
        $this->rawXml()->shouldReturn(self::XML);
        $this->orderCode()->shouldBeLike(new OrderCode("order-reiss-test-123"));
    }

    function it_returns_the_error_code_and_message()
    {
        $this->beConstructedWith(self::ERROR_XML);

        $this->errorCode()->shouldReturn(self::ERROR_CODE);
        $this->errorMessage()->shouldReturn(self::ERROR_MSG);
    }
}
