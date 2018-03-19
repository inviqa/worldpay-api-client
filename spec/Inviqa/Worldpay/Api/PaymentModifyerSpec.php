<?php

namespace spec\Inviqa\Worldpay\Api;

use Inviqa\Worldpay\Api\Client;
use Inviqa\Worldpay\Api\Request\ModifyRequestFactory;
use Inviqa\Worldpay\Api\Request\PaymentService;
use Inviqa\Worldpay\Api\Response\CaptureResponse;
use Inviqa\Worldpay\Api\Response\ModifiedResponse;
use Inviqa\Worldpay\Api\XmlNodeConverter;
use PhpSpec\ObjectBehavior;

class PaymentModifyerSpec extends ObjectBehavior
{
    function let(
        ModifyRequestFactory $modifyRequestFactory,
        XmlNodeConverter $xmlNodeConverter,
        Client $client
    ) {
        $this->beConstructedWith($modifyRequestFactory, $xmlNodeConverter, $client);
    }

    function it_delegates_building_of_a_request_and_sending_it_to_the_client(
        ModifyRequestFactory $modifyRequestFactory,
        XmlNodeConverter $xmlNodeConverter,
        Client $client,
        PaymentService $paymentService
    ) {
        $requestParameters = ["foo" => "bar"];
        $requestXml = "<foo>bar</foo>";
        $responseXml = "<bar>foo</bar>";

        $modifyRequestFactory->buildCaptureFromRequestParameters($requestParameters)->willReturn($paymentService);
        $xmlNodeConverter->toXml($paymentService)->willReturn($requestXml);
        $httpResponse = Client\HttpResponse::fromContentAndCookie($responseXml);
        $client->sendRequest($requestXml, null)->willReturn($httpResponse);

        $this->capturePayment($requestParameters)->shouldBeLike(new CaptureResponse($httpResponse));
    }
}
