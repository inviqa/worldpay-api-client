<?php

namespace Inviqa\Worldpay\Api;

use Inviqa\Worldpay\Api\Exception\ConnectionFailedException;
use Inviqa\Worldpay\Api\Request\CancelRequestFactory;
use Inviqa\Worldpay\Api\Request\CaptureRequestFactory;
use Inviqa\Worldpay\Api\Request\PaymentService;
use Inviqa\Worldpay\Api\Request\RefundRequestFactory;
use Inviqa\Worldpay\Api\Response\CancelResponse;
use Inviqa\Worldpay\Api\Response\CaptureResponse;
use Inviqa\Worldpay\Api\Response\ModifiedResponse;
use Inviqa\Worldpay\Api\Response\RefundResponse;

class PaymentModifier
{
    /**
     * @var CaptureRequestFactory
     */
    private $captureRequestFactory;

    /**
     * @var XmlNodeConverter
     */
    private $xmlNodeConverter;

    /**
     * @var Client
     */
    private $client;
    /**
     * @var RefundRequestFactory
     */
    private $refundRequestFactory;

    /**
     * @var CancelRequestFactory
     */
    private $cancelRequestFactory;

    /**
     * @param CaptureRequestFactory $captureRequestFactory
     * @param RefundRequestFactory  $refundRequestFactory
     * @param CancelRequestFactory  $cancelRequestFactory
     * @param XmlNodeConverter      $xmlNodeConverter
     * @param Client                $client
     */
    public function __construct(
        CaptureRequestFactory $captureRequestFactory,
        RefundRequestFactory $refundRequestFactory,
        CancelRequestFactory $cancelRequestFactory,
        XmlNodeConverter $xmlNodeConverter,
        Client $client
    ) {
        $this->captureRequestFactory = $captureRequestFactory;
        $this->xmlNodeConverter      = $xmlNodeConverter;
        $this->client                = $client;
        $this->refundRequestFactory  = $refundRequestFactory;
        $this->cancelRequestFactory = $cancelRequestFactory;
    }

    /**
     * @param array $paymentParameters
     *
     * @return mixed
     *
     * @throws ConnectionFailedException
     */
    public function capturePayment(array $paymentParameters)
    {
        $paymentService = $this->captureRequestFactory->buildFromRequestParameters($paymentParameters);

        return $this->makeRequest($paymentService, CaptureResponse::class);
    }

    /**
     * @param array $paymentParameters
     *
     * @return mixed
     *
     * @throws ConnectionFailedException
     */
    public function refundPayment(array $paymentParameters)
    {
        $paymentService = $this->refundRequestFactory->buildFromRequestParameters($paymentParameters);

        return $this->makeRequest($paymentService, RefundResponse::class);
    }

    /**
     * @param array $paymentParameters
     *
     * @return mixed
     *
     * @throws ConnectionFailedException
     */
    public function cancelPayment(array $paymentParameters)
    {
        $paymentService = $this->cancelRequestFactory->buildFromRequestParameters($paymentParameters);

        return $this->makeRequest($paymentService, CancelResponse::class);
    }

    /**
     * @param $paymentService
     *
     * @param string $responseClass
     * @return Client\HttpResponse
     * @throws ConnectionFailedException
     */
    private function makeRequest($paymentService, string $responseClass)
    {
        try {
            $requestXml = $this->xmlNodeConverter->toXml($paymentService);
            $httpResponse = $this->client->sendRequest($requestXml);

            return new $responseClass($httpResponse, $requestXml);
        } catch (\Exception $e) {
            throw new ConnectionFailedException(
                sprintf("Worldpay connection failure. Error message: %s", $e->getMessage())
            );
        }
    }
}
