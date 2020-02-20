<?php

namespace Inviqa\Worldpay\Api;

use Inviqa\Worldpay\Api\Exception\ConnectionFailedException;
use Inviqa\Worldpay\Api\Request\PaymentService;
use Inviqa\Worldpay\Api\Request\RequestFactory;
use Inviqa\Worldpay\Api\Request\ThreeDSRequestFactory;
use Inviqa\Worldpay\Api\Response\AuthorisedResponse;

class PaymentAuthorizer
{
    private $authRequestFactory;
    private $threeDSRequestFactory;
    private $xmlNodeConverter;
    private $client;

    private function __construct()
    {
    }

    public static function worldpayAuthorizer(
        RequestFactory $authRequestFactory,
        ThreeDSRequestFactory $threeDSRequestFactory,
        XmlNodeConverter $xmlNodeConverter,
        Client $client
    ) {
        $instance = new self();
        $instance->authRequestFactory = $authRequestFactory;
        $instance->threeDSRequestFactory = $threeDSRequestFactory;
        $instance->xmlNodeConverter = $xmlNodeConverter;
        $instance->client = $client;

        return $instance;
    }

    public static function applePayAuthorizer(
        RequestFactory $authRequestFactory,
        XmlNodeConverter $xmlNodeConverter,
        Client $client
    ) {
        $instance = new self();
        $instance->authRequestFactory = $authRequestFactory;
        $instance->xmlNodeConverter = $xmlNodeConverter;
        $instance->client = $client;

        return $instance;
    }

    public static function googlePayAuthorizer(
        RequestFactory $authRequestFactory,
        XmlNodeConverter $xmlNodeConverter,
        Client $client
    ) {
        $instance = new self();
        $instance->authRequestFactory = $authRequestFactory;
        $instance->xmlNodeConverter = $xmlNodeConverter;
        $instance->client = $client;

        return $instance;
    }

    /**
     * @param array $paymentParameters
     *
     * @return AuthorisedResponse
     *
     * @throws ConnectionFailedException
     * @throws Exception\InvalidRequestParameterException
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
     *
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
