<?php

namespace Inviqa\Worldpay\Api;

use Inviqa\Worldpay\Api\Exception\ConnectionFailedException;
use Inviqa\Worldpay\Api\Request\AuthorizeRequestFactory;
use Inviqa\Worldpay\Api\Request\ThreeDSRequestFactory;
use Inviqa\Worldpay\Api\Response\AuthorisedResponse;
use Inviqa\Worldpay\Api\Response\ResponseFactory;

class PaymentAuthorizer
{
    private $authRequestFactory;
    private $threeDSRequestFactory;
    private $xmlNodeConverter;
    private $client;

    public function __construct(
        AuthorizeRequestFactory $authRequestFactory,
        ThreeDSRequestFactory $threeDSRequestFactory,
        XmlNodeConverter $xmlNodeConverter,
        Client $client
    )
    {
        $this->authRequestFactory = $authRequestFactory;
        $this->threeDSRequestFactory = $threeDSRequestFactory;
        $this->xmlNodeConverter = $xmlNodeConverter;
        $this->client = $client;
    }

    /**
     * @param array $paymentParameters
     * @return AuthorisedResponse
     * @throws ConnectionFailedException
     */
    public function authorizePayment(array $paymentParameters)
    {
        $paymentService = $this->authRequestFactory->buildFromRequestParameters($paymentParameters);

        return $this->makeRequest($paymentService);
    }

    /**
     * @param array $paymentParameters
     * @return AuthorisedResponse
     * @throws ConnectionFailedException
     * @throws Exception\InvalidRequestParameterException
     */
    public function authorize3DSecure(array $paymentParameters)
    {
        $paymentService = $this->threeDSRequestFactory->buildFromRequestParameters($paymentParameters);

        return $this->makeRequest($paymentService, $paymentParameters['cookie']);
    }

    /**
     * @param $paymentService
     * @return AuthorisedResponse
     * @throws ConnectionFailedException
     */
    private function makeRequest($paymentService, string $cookie = null)
    {
        try {
            $httpResponse = $this->client->sendRequest(
                $this->xmlNodeConverter->toXml($paymentService),
                $cookie
            );

            return new AuthorisedResponse($httpResponse);
        } catch (\Exception $e) {
            throw new ConnectionFailedException(
                sprintf("Worldpay connection failure. Error message: %s", $e->getMessage())
            );
        }
    }
}
