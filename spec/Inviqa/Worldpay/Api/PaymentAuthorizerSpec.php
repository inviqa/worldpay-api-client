<?php

namespace spec\Inviqa\Worldpay\Api;

use Inviqa\Worldpay\Api\Client;
use Inviqa\Worldpay\Api\Client\HttpResponse;
use Inviqa\Worldpay\Api\Exception\ConnectionFailedException;
use Inviqa\Worldpay\Api\Request\PaymentService;
use Inviqa\Worldpay\Api\Request\AuthorizeRequestFactory;
use Inviqa\Worldpay\Api\Request\ThreeDSFlexRequestFactory;
use Inviqa\Worldpay\Api\Request\ThreeDSRequestFactory;
use Inviqa\Worldpay\Api\Response\AuthorisedResponse;
use Inviqa\Worldpay\Api\Response\ResponseFactory;
use Inviqa\Worldpay\Api\XmlNodeConverter;
use PhpSpec\ObjectBehavior;

class PaymentAuthorizerSpec extends ObjectBehavior
{
    const REQUEST_XML = "<foo><bar></bar></foo>";

    function let(
        AuthorizeRequestFactory $authorizeRequestFactory,
        ThreeDSRequestFactory $threeDSRequestFactory,
        ThreeDSFlexRequestFactory $threeDSFlexRequestFactory,
        XmlNodeConverter $xmlNodeConverter,
        Client $client
    ) {
        $this->beConstructedWorldpayAuthorizer(
            $authorizeRequestFactory,
            $threeDSRequestFactory,
            $threeDSFlexRequestFactory,
            $xmlNodeConverter,
            $client
        );
    }

    function it_delegates_building_of_a_request_and_sending_it_to_the_client(
        AuthorizeRequestFactory $authorizeRequestFactory,
        XmlNodeConverter $xmlNodeConverter,
        Client $client,
        PaymentService $paymentService
    ) {
        $requestParameters = ["foo" => "bar"];
        $responseXml = "<bar>foo</bar>";

        $authorizeRequestFactory->buildFromRequestParameters($requestParameters)->willReturn($paymentService);
        $xmlNodeConverter->toXml($paymentService)->willReturn(self::REQUEST_XML);
        $httpResponse = HttpResponse::fromContentAndCookie($responseXml, self::REQUEST_XML);
        $client->sendRequest(self::REQUEST_XML, null)->willReturn($httpResponse);

        $this->authorizePayment($requestParameters)->shouldHaveRequestAndResponse(self::REQUEST_XML, $httpResponse);
    }

    function it_throws_a_connection_failed_exception_when_the_client_throws_an_exception(
        AuthorizeRequestFactory $authorizeRequestFactory,
        XmlNodeConverter $xmlNodeConverter,
        Client $client,
        PaymentService $paymentService
    ) {
        $requestParameters = ["foo" => "bar"];
        $authorizeRequestFactory->buildFromRequestParameters($requestParameters)->willReturn($paymentService);
        $xmlNodeConverter->toXml($paymentService)->willReturn(self::REQUEST_XML);

        $client->sendRequest(self::REQUEST_XML, null)->willThrow(new \Exception());

        $this->shouldThrow(ConnectionFailedException::class)->duringAuthorizePayment($requestParameters);
    }

    function it_delegates_building_3ds_request_and_sending_it_to_the_client(
        ThreeDSRequestFactory $threeDSRequestFactory,
        XmlNodeConverter $xmlNodeConverter,
        Client $client,
        PaymentService $paymentService
    ) {
        $requestParameters = ["foo" => "bar", "cookie" => "cookie value"];
        $responseXml = "<bar>foo</bar>";

        $threeDSRequestFactory->buildFromRequestParameters($requestParameters)->willReturn($paymentService);
        $xmlNodeConverter->toXml($paymentService)->willReturn(self::REQUEST_XML);
        $httpResponse = HttpResponse::fromContentAndCookie($responseXml, self::REQUEST_XML);
        $client->sendRequest(self::REQUEST_XML, "cookie value")->willReturn($httpResponse);

        $this->authorize3DSecure($requestParameters)->shouldHaveRequestAndResponse(self::REQUEST_XML, $httpResponse);
    }

    public function getMatchers(): array
    {
        return [
            'haveRequestAndResponse' => function (
                AuthorisedResponse $subject,
                string $requestXml,
                HttpResponse $response
            ) {
                return $subject->rawXml() === $response->content() && $subject->rawRequestXml() === $requestXml;
            },
        ];
    }
}
