<?php

namespace spec\Inviqa\Worldpay\Api;

use Inviqa\Worldpay\Api\Client;
use Inviqa\Worldpay\Api\Request\CancelRequestFactory;
use Inviqa\Worldpay\Api\Request\CaptureRequestFactory;
use Inviqa\Worldpay\Api\Request\PaymentService;
use Inviqa\Worldpay\Api\Request\RefundRequestFactory;
use Inviqa\Worldpay\Api\Response\CaptureResponse;
use Inviqa\Worldpay\Api\Response\RefundResponse;
use Inviqa\Worldpay\Api\XmlNodeConverter;
use PhpSpec\ObjectBehavior;

class PaymentModifierSpec extends ObjectBehavior
{
    function let(
        CaptureRequestFactory $captureRequestFactory,
        RefundRequestFactory $refundRequestFactory,
        CancelRequestFactory $cancelRequestFactory,
        XmlNodeConverter $xmlNodeConverter,
        Client $client
    ) {
        $this->beConstructedWith(
            $captureRequestFactory,
            $refundRequestFactory,
            $cancelRequestFactory,
            $xmlNodeConverter,
            $client
        );
    }

    function it_delegates_building_of_a_capture_request_and_sending_it_to_the_client(
        CaptureRequestFactory $captureRequestFactory,
        XmlNodeConverter $xmlNodeConverter,
        Client $client,
        PaymentService $paymentService
    ) {
        $requestParameters = ["foo" => "bar"];
        $requestXml = "<foo>bar</foo>";
        $responseXml = "<bar>foo</bar>";

        $captureRequestFactory->buildFromRequestParameters($requestParameters)->willReturn($paymentService);
        $xmlNodeConverter->toXml($paymentService)->willReturn($requestXml);
        $httpResponse = Client\HttpResponse::fromContentAndCookie($responseXml);
        $client->sendRequest($requestXml, null)->willReturn($httpResponse);

        $this->capturePayment($requestParameters)->shouldBeLike(new CaptureResponse($httpResponse));
    }

    function it_delegates_building_of_a_refund_request_and_sending_it_to_the_client(
        RefundRequestFactory $refundRequestFactory,
        XmlNodeConverter $xmlNodeConverter,
        Client $client,
        PaymentService $paymentService
    ) {
        $requestParameters = ["foo" => "bar"];
        $requestXml = "<foo>bar</foo>";
        $responseXml = "<bar>foo</bar>";

        $refundRequestFactory->buildFromRequestParameters($requestParameters)->willReturn($paymentService);
        $xmlNodeConverter->toXml($paymentService)->willReturn($requestXml);
        $httpResponse = Client\HttpResponse::fromContentAndCookie($responseXml);
        $client->sendRequest($requestXml, null)->willReturn($httpResponse);

        $this->refundPayment($requestParameters)->shouldBeLike(new RefundResponse($httpResponse));
    }
}
