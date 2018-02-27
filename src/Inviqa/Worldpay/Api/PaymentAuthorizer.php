<?php

namespace Inviqa\Worldpay\Api;

use Inviqa\Worldpay\Api\Exception\ConnectionFailedException;
use Inviqa\Worldpay\Api\Request\RequestFactory;
use Inviqa\Worldpay\Api\Response\AuthorisedResponse;
use Inviqa\Worldpay\Api\Response\ResponseFactory;

class PaymentAuthorizer
{
    private $requestFactory;
    private $xmlNodeConverter;
    private $client;

    public function __construct(
        RequestFactory $requestFactory,
        XmlNodeConverter $xmlNodeConverter,
        Client $client
    )
    {
        $this->requestFactory = $requestFactory;
        $this->xmlNodeConverter = $xmlNodeConverter;
        $this->client = $client;
    }

    /**
     * @param array $paymentParameters
     *
     * @return AuthorisedResponse
     * @throws ConnectionFailedException
     */
    public function authorizePayment(array $paymentParameters)
    {
        $paymentService = $this->requestFactory->buildFromRequestParameters($paymentParameters);

        try {
            $responseXml = $this->client->sendAuthorizationRequest(
                $this->xmlNodeConverter->toXml($paymentService)
            );

            return ResponseFactory::responseFromXml($responseXml);
        } catch (\Exception $e) {
            throw new ConnectionFailedException(
                sprintf("Worldpay connection failure. Error message: %s", $e->getMessage())
            );
        }
    }
}
