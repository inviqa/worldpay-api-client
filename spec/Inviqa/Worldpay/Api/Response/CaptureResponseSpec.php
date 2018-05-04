<?php

namespace spec\Inviqa\Worldpay\Api\Response;

use Inviqa\Worldpay\Api\Client\HttpResponse;
use Inviqa\Worldpay\Api\Response\PaymentService\Reply\OrderStatus\OrderCode;
use PhpSpec\ObjectBehavior;

class CaptureResponseSpec extends ObjectBehavior
{
    const XML = '<reply><ok><captureReceived orderCode="order-reiss-mar-15-1"><amount value="10965" currencyCode="EUR" exponent="2" debitCreditIndicator="credit"/></captureReceived></ok>';

    function it_returns_the_response_details_for_a_capture_modify_request()
    {
        $this->beConstructedWith(HttpResponse::fromContentAndCookie(self::XML, "foo:bar"), "<foo/>");

        $this->isSuccessful()->shouldReturn(true);
        $this->rawXml()->shouldReturn(self::XML);
        $this->orderCode()->shouldBeLike(new OrderCode("order-reiss-mar-15-1"));
        $this->machineCookie()->shouldReturn("foo:bar");
        $this->rawRequestXml()->shouldReturn("<foo/>");
    }
}
