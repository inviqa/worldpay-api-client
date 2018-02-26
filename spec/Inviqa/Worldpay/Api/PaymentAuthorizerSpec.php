<?php

namespace spec\Inviqa\Worldpay\Api;

use Inviqa\Worldpay\Api\Request\PaymentService;
use Inviqa\Worldpay\Api\Response\AuthorizedResponse;
use Inviqa\Worldpay\Api\XmlNodeConverter;
use PhpSpec\ObjectBehavior;
use Inviqa\Worldpay\Api\Request\RequestFactory;
use Inviqa\Worldpay\Api\Client;

class PaymentAuthorizerSpec extends ObjectBehavior
{
    function let(
        RequestFactory $requestFactory,
        XmlNodeConverter $xmlNodeConverter,
        Client $client
    ) {
        $this->beConstructedWith($requestFactory, $xmlNodeConverter, $client);
    }

    function it_delegates_building_of_a_request_and_sending_it_to_the_client(
        RequestFactory $requestFactory,
        XmlNodeConverter $xmlNodeConverter,
        Client $client,
        PaymentService $paymentService
    )
    {
        $requestParameters = ["foo" => "bar"];
        $requestXml = "<foo>bar</foo>";

        $requestFactory->buildFromRequestParameters($requestParameters)->willReturn($paymentService);
        $xmlNodeConverter->toXml($paymentService)->willReturn($requestXml);
        $client->sendAuthorizationRequest($requestXml)->shouldBeCalled();

        $this->authorizePayment($requestParameters)->shouldBeLike(
            new AuthorizedResponse()
        );
    }
}
