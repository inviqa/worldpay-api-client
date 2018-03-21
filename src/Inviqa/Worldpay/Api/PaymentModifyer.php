<?php

namespace Inviqa\Worldpay\Api;

use Inviqa\Worldpay\Api\Exception\ConnectionFailedException;
use Inviqa\Worldpay\Api\Request\CaptureRequestFactory;
use Inviqa\Worldpay\Api\Request\PaymentService;
use Inviqa\Worldpay\Api\Request\RefundRequestFactory;
use Inviqa\Worldpay\Api\Response\CaptureResponse;
use Inviqa\Worldpay\Api\Response\ModifiedResponse;
use Inviqa\Worldpay\Api\Response\RefundResponse;

class PaymentModifyer
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
     * @param CaptureRequestFactory $captureRequestFactory
     * @param RefundRequestFactory  $refundRequestFactory
     * @param XmlNodeConverter      $xmlNodeConverter
     * @param Client                $client
     */
    public function __construct(
        CaptureRequestFactory $captureRequestFactory,
        RefundRequestFactory $refundRequestFactory,
        XmlNodeConverter $xmlNodeConverter,
        Client $client
    ) {
        $this->captureRequestFactory = $captureRequestFactory;
        $this->xmlNodeConverter      = $xmlNodeConverter;
        $this->client                = $client;
        $this->refundRequestFactory  = $refundRequestFactory;
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

        return new CaptureResponse($this->makeRequest($paymentService));
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

        return new RefundResponse($this->makeRequest($paymentService));
    }

    /**
     * @param $paymentService
     *
     * @return Client\HttpResponse
     * @throws ConnectionFailedException
     */
    private function makeRequest($paymentService)
    {
        try {
            $httpResponse = $this->client->sendRequest(
                $this->xmlNodeConverter->toXml($paymentService)
            );

            return $httpResponse;
        } catch (\Exception $e) {
            throw new ConnectionFailedException(
                sprintf("Worldpay connection failure. Error message: %s", $e->getMessage())
            );
        }
    }
}
