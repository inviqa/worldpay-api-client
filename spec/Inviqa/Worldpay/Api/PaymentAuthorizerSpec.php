<?php

namespace spec\Inviqa\Worldpay\Api;

use Inviqa\Worldpay\Api\Client;
use Inviqa\Worldpay\Api\Exception\ConnectionFailedException;
use Inviqa\Worldpay\Api\Request\PaymentService;
use Inviqa\Worldpay\Api\Request\RequestFactory;
use Inviqa\Worldpay\Api\Response\ResponseFactory;
use Inviqa\Worldpay\Api\XmlNodeConverter;
use PhpSpec\ObjectBehavior;

class PaymentAuthorizerSpec extends ObjectBehavior
{
    function let(
        RequestFactory $requestFactory,
        XmlNodeConverter $xmlNodeConverter,
        Client $client
    )
    {
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
        $responseXml = "<bar>foo</bar>";

        $requestFactory->buildFromRequestParameters($requestParameters)->willReturn($paymentService);
        $xmlNodeConverter->toXml($paymentService)->willReturn($requestXml);
        $client->sendAuthorizationRequest($requestXml)->willReturn($responseXml);

        $this->authorizePayment($requestParameters)->shouldBeLike(ResponseFactory::responseFromXml($responseXml));
    }

    function it_throws_a_connection_failed_exception_when_the_client_throws_an_exception(
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

        $client->sendAuthorizationRequest($requestXml)->willThrow(\Exception::class);

        $this->shouldThrow(ConnectionFailedException::class)->duringAuthorizePayment($requestParameters);
    }
}
