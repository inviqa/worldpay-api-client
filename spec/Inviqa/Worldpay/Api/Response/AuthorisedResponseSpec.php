<?php

namespace spec\Inviqa\Worldpay\Api\Response;

use Inviqa\Worldpay\Api\Client\HttpResponse;
use Inviqa\Worldpay\Api\Response\PaymentService\Reply\OrderStatus\OrderCode;
use PhpSpec\ObjectBehavior;

class AuthorisedResponseSpec extends ObjectBehavior
{
    const XML = "<reply><orderStatus orderCode=\"order-ecomm-test-123\"><lastEvent>AUTHORISED</lastEvent></orderStatus></reply>";
    const REQUEST_XML = "<foo><bar></bar></foo>";
    const XML_3DS = "<reply><orderStatus orderCode=\"order-ecomm-test-123\"><request3DSecure><paRequest>abc</paRequest><issuerURL><![CDATA[localhost]]></issuerURL></request3DSecure></orderStatus></reply>";
    const ERROR_XML = "<reply><error code=\"" . self::ERROR_CODE . "\"><![CDATA[" . self::ERROR_MSG . "]]></error></reply>";
    const ERROR_MSG = "An internal CSE service error has occurred.";
    const ERROR_CODE = "5";

    function it_returns_the_response_details_when_the_last_event_is_authorised()
    {
        $this->beConstructedWith(
            HttpResponse::fromContentAndCookie(self::XML, "foo:bar"),
            self::REQUEST_XML
        );

        $this->isSuccessful()->shouldReturn(true);
        $this->rawXml()->shouldReturn(self::XML);
        $this->orderCode()->shouldBeLike(new OrderCode("order-ecomm-test-123"));
        $this->machineCookie()->shouldReturn("foo:bar");
    }

    function it_returns_the_error_code_and_message()
    {
        $this->beConstructedWith(
            HttpResponse::fromContentAndCookie(self::ERROR_XML),
            self::REQUEST_XML
        );

        $this->errorCode()->shouldReturn(self::ERROR_CODE);
        $this->errorMessage()->shouldReturn(self::ERROR_MSG);
        $this->paRequestValue()->shouldReturn("");
    }

    function it_returns_3dsecure_data_when_the_response_contains_the_request3DSecure_node()
    {
        $this->beConstructedWith(
            HttpResponse::fromContentAndCookie(self::XML_3DS),
            self::REQUEST_XML
        );

        $this->is3DSecure()->shouldReturn(true);
        $this->isSuccessful()->shouldReturn(false);
        $this->paRequestValue()->shouldReturn("abc");
        $this->issuerURL()->shouldReturn("localhost");
    }
}
