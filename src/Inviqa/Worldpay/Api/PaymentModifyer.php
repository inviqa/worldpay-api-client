<?php

namespace Inviqa\Worldpay\Api;

use Inviqa\Worldpay\Api\Exception\ConnectionFailedException;
use Inviqa\Worldpay\Api\Request\ModifyRequestFactory;
use Inviqa\Worldpay\Api\Request\PaymentService;
use Inviqa\Worldpay\Api\Response\CaptureResponse;
use Inviqa\Worldpay\Api\Response\ModifiedResponse;

class PaymentModifyer
{
    /**
     * @var ModifyRequestFactory
     */
    private $modifyRequestFactory;

    /**
     * @var XmlNodeConverter
     */
    private $xmlNodeConverter;

    /**
     * @var Client
     */
    private $client;

    /**
     * @param ModifyRequestFactory $modifyRequestFactory
     * @param XmlNodeConverter     $xmlNodeConverter
     * @param Client               $client
     */
    public function __construct(
        ModifyRequestFactory $modifyRequestFactory,
        XmlNodeConverter $xmlNodeConverter,
        Client $client
    ) {
        $this->modifyRequestFactory = $modifyRequestFactory;
        $this->xmlNodeConverter     = $xmlNodeConverter;
        $this->client               = $client;
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
        $paymentService = $this->modifyRequestFactory->buildCaptureFromRequestParameters($paymentParameters);

        return $this->makeRequest($paymentService);
    }

    /**
     * @param PaymentService $paymentService
     *
     * @return ModifiedResponse
     * @throws ConnectionFailedException
     */
    private function makeRequest($paymentService)
    {
        try {
            $httpResponse = $this->client->sendRequest(
                $this->xmlNodeConverter->toXml($paymentService)
            );

            return new CaptureResponse($httpResponse);
        } catch (\Exception $e) {
            throw new ConnectionFailedException(
                sprintf("Worldpay connection failure. Error message: %s", $e->getMessage())
            );
        }
    }
}
