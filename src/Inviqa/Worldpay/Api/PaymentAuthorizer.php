<?php

namespace Inviqa\Worldpay\Api;

use Inviqa\Worldpay\Api\Exception\ConnectionFailedException;
use Inviqa\Worldpay\Api\Request\AuthorizeRequestFactory;
use Inviqa\Worldpay\Api\Request\PaymentService;
use Inviqa\Worldpay\Api\Request\ThreeDSRequestFactory;
use Inviqa\Worldpay\Api\Response\AuthorisedResponse;

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
    ) {
        $this->authRequestFactory = $authRequestFactory;
        $this->threeDSRequestFactory = $threeDSRequestFactory;
        $this->xmlNodeConverter = $xmlNodeConverter;
        $this->client = $client;
    }

    /**
     * @param array $paymentParameters
     *
     * @return AuthorisedResponse
     * @throws ConnectionFailedException
     */
    public function authorizePayment(array $paymentParameters): AuthorisedResponse
    {
        return $this->makeRequest(
            $this->authRequestFactory->buildFromRequestParameters($paymentParameters)
        );
    }

    /**
     * @param array $paymentParameters
     *
     * @return AuthorisedResponse
     * @throws ConnectionFailedException
     * @throws Exception\InvalidRequestParameterException
     */
    public function authorize3DSecure(array $paymentParameters)
    {
        return $this->makeRequest(
            $this->threeDSRequestFactory->buildFromRequestParameters($paymentParameters),
            $paymentParameters['cookie']
        );
    }

    /**
     * @param PaymentService $paymentService
     *
     * @param string|null $cookie
     * @return AuthorisedResponse
     * @throws ConnectionFailedException
     */
    private function makeRequest(PaymentService $paymentService, string $cookie = null)
    {
        try {
            $requestXml = $this->xmlNodeConverter->toXml($paymentService);

            $httpResponse = $this->client->sendRequest(
                $requestXml,
                $cookie
            );

            return new AuthorisedResponse($httpResponse, $requestXml);
        } catch (\Exception $e) {
            throw new ConnectionFailedException(
                sprintf("Worldpay connection failure. Error message: %s", $e->getMessage())
            );
        }
    }
}
