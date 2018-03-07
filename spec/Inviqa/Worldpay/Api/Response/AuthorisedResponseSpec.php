<?php

namespace spec\Inviqa\Worldpay\Api\Response;

use Inviqa\Worldpay\Api\Response\AuthorisedResponse;
use Inviqa\Worldpay\Api\Response\PaymentService\Reply\OrderStatus\OrderCode;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AuthorisedResponseSpec extends ObjectBehavior
{
    const XML = "<reply><orderStatus orderCode=\"order-ecomm-test-123\"><lastEvent>AUTHORISED</lastEvent></orderStatus></reply>";
    const XML_3DS = "<reply><orderStatus orderCode=\"order-ecomm-test-123\"><request3DSecure><paRequest>abc</paRequest><issuerURL><![CDATA[localhost]]></issuerURL></request3DSecure></orderStatus></reply>";
    const ERROR_XML = "<reply><error code=\"" . self::ERROR_CODE . "\"><![CDATA[" . self::ERROR_MSG . "]]></error></reply>";
    const ERROR_MSG = "An internal CSE service error has occurred.";
    const ERROR_CODE = "5";

    function it_returns_the_response_details_when_the_last_event_is_authorised()
    {
        $this->beConstructedWith(self::XML);

        $this->isSuccessful()->shouldReturn(true);
        $this->rawXml()->shouldReturn(self::XML);
        $this->orderCode()->shouldBeLike(new OrderCode("order-ecomm-test-123"));
    }

    function it_returns_the_error_code_and_message()
    {
        $this->beConstructedWith(self::ERROR_XML);

        $this->errorCode()->shouldReturn(self::ERROR_CODE);
        $this->errorMessage()->shouldReturn(self::ERROR_MSG);
        $this->paRequestValue()->shouldReturn("");
    }

    function it_returns_true_when_the_response_contains_the_request3DSecure_node()
    {
        $this->beConstructedWith(self::XML_3DS);

        $this->is3DSecure()->shouldReturn(true);
        $this->isSuccessful()->shouldReturn(false);
    }

    function it_returns_the_parequest_value_when_the_xml_contains_one()
    {
        $this->beConstructedWith(self::XML_3DS);

        $this->paRequestValue()->shouldReturn("abc");
    }

    function it_returns_the_issuer_url_when_the_xml_contains_one()
    {
        $this->beConstructedWith(self::XML_3DS);

        $this->issuerURL()->shouldReturn("localhost");
    }
}
