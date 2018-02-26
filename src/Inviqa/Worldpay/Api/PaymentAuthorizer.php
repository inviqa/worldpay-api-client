<?php

namespace Inviqa\Worldpay\Api;

use Inviqa\Worldpay\Api\Request\RequestFactory;
use Inviqa\Worldpay\Api\Response\AuthorizedResponse;

class PaymentAuthorizer
{
    private $requestFactory;
    private $xmlNodeConverter;
    private $client;

    public function __construct(
        RequestFactory $requestFactory,
        XmlNodeConverter $xmlNodeConverter,
        Client $client
    ) {
        $this->requestFactory = $requestFactory;
        $this->xmlNodeConverter = $xmlNodeConverter;
        $this->client = $client;
    }

    public function authorizePayment(array $paymentParameters)
    {
        $paymentService = $this->requestFactory->buildFromRequestParameters($paymentParameters);

        $this->client->sendAuthorizationRequest(
            $this->xmlNodeConverter->toXml($paymentService)
        );

        return new AuthorizedResponse();
    }
}
