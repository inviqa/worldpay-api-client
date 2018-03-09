<?php

namespace spec\Inviqa\Worldpay\Api;

use Inviqa\Worldpay\Api\Client;
use Inviqa\Worldpay\Api\Client\HttpResponse;
use Inviqa\Worldpay\Api\Exception\ConnectionFailedException;
use Inviqa\Worldpay\Api\Request\PaymentService;
use Inviqa\Worldpay\Api\Request\AuthorizeRequestFactory;
use Inviqa\Worldpay\Api\Request\ThreeDSRequestFactory;
use Inviqa\Worldpay\Api\Response\AuthorisedResponse;
use Inviqa\Worldpay\Api\Response\ResponseFactory;
use Inviqa\Worldpay\Api\XmlNodeConverter;
use PhpSpec\ObjectBehavior;

class PaymentAuthorizerSpec extends ObjectBehavior
{
    function let(
        AuthorizeRequestFactory $authorizeRequestFactory,
        ThreeDSRequestFactory $threeDSRequestFactory,
        XmlNodeConverter $xmlNodeConverter,
        Client $client
    ) {
        $this->beConstructedWith($authorizeRequestFactory,$threeDSRequestFactory, $xmlNodeConverter, $client);
    }

    function it_delegates_building_of_a_request_and_sending_it_to_the_client(
        AuthorizeRequestFactory $authorizeRequestFactory,
        XmlNodeConverter $xmlNodeConverter,
        Client $client,
        PaymentService $paymentService
    ) {
        $requestParameters = ["foo" => "bar"];
        $requestXml = "<foo>bar</foo>";
        $responseXml = "<bar>foo</bar>";

        $authorizeRequestFactory->buildFromRequestParameters($requestParameters)->willReturn($paymentService);
        $xmlNodeConverter->toXml($paymentService)->willReturn($requestXml);
        $httpResponse = HttpResponse::fromContentAndCookie($responseXml);
        $client->sendRequest($requestXml, null)->willReturn($httpResponse);

        $this->authorizePayment($requestParameters)->shouldBeLike(new AuthorisedResponse($httpResponse));
    }

    function it_throws_a_connection_failed_exception_when_the_client_throws_an_exception(
        AuthorizeRequestFactory $authorizeRequestFactory,
        XmlNodeConverter $xmlNodeConverter,
        Client $client,
        PaymentService $paymentService
    ) {
        $requestParameters = ["foo" => "bar"];
        $requestXml = "<foo>bar</foo>";

        $authorizeRequestFactory->buildFromRequestParameters($requestParameters)->willReturn($paymentService);
        $xmlNodeConverter->toXml($paymentService)->willReturn($requestXml);

        $client->sendRequest($requestXml)->willThrow(\Exception::class);

        $this->shouldThrow(ConnectionFailedException::class)->duringAuthorizePayment($requestParameters);
    }

    function it_delegates_building_3ds_request_and_sending_it_to_the_client(
        ThreeDSRequestFactory $threeDSRequestFactory,
        XmlNodeConverter $xmlNodeConverter,
        Client $client,
        PaymentService $paymentService
    ) {
        $requestParameters = ["foo" => "bar", "cookie" => "cookie value"];
        $requestXml = "<foo>bar</foo>";
        $responseXml = "<bar>foo</bar>";

        $threeDSRequestFactory->buildFromRequestParameters($requestParameters)->willReturn($paymentService);
        $xmlNodeConverter->toXml($paymentService)->willReturn($requestXml);
        $httpResponse = HttpResponse::fromContentAndCookie($responseXml);
        $client->sendRequest($requestXml, "cookie value")->willReturn($httpResponse);

        $this->authorize3DSecure($requestParameters)->shouldBeLike(new AuthorisedResponse($httpResponse));
    }
}
