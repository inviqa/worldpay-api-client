<?php

namespace spec\Inviqa\Worldpay\Api\Client;

use Inviqa\Worldpay\Api\Client\HttpResponse;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class HttpResponseSpec extends ObjectBehavior
{
    function it_returns_the_response_content_and_cookie()
    {
        $this->beConstructedFromContentAndCookie("content", "cookie-value");

        $this->content()->shouldReturn("content");
        $this->cookie()->shouldReturn("cookie-value");
    }
}
