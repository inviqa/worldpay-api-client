<?php

namespace Inviqa\Worldpay;

use Inviqa\Worldpay\Api\Client;
use Inviqa\Worldpay\Api\Client\ClientFactory;
use Inviqa\Worldpay\Api\Exception\WorldpayException;
use Inviqa\Worldpay\Api\PaymentAuthorizer;
use Inviqa\Worldpay\Api\PaymentModifyer;
use Inviqa\Worldpay\Api\Request\AuthorizeRequestFactory;
use Inviqa\Worldpay\Api\Request\ModifyRequestFactory;
use Inviqa\Worldpay\Api\Request\ThreeDSRequestFactory;
use Inviqa\Worldpay\Api\Response\AuthorisedResponse;
use Inviqa\Worldpay\Api\Response\CaptureResponse;
use Inviqa\Worldpay\Api\XmlNodeConverter;
use Inviqa\Worldpay\Notification\Response\NotificationResponse;
use Sabre\Xml\Writer;

class Application
{
    private $paymentAuthorizer;
    private $client;
    private $paymentModifier;

    public function __construct(Config $config)
    {
        $clientFactory = new ClientFactory($config);

        /** @var Client $client */
        $this->client = $clientFactory->getClient();

        $this->paymentAuthorizer = new PaymentAuthorizer(
            new AuthorizeRequestFactory(),
            new ThreeDSRequestFactory(),
            new XmlNodeConverter(
                new Writer()
            ),
            $this->client
        );

        $this->paymentModifier = new PaymentModifyer(
            new ModifyRequestFactory(),
            new XmlNodeConverter(
                new Writer()
            ),
            $this->client
        );
    }

    /**
     * @param array $paymentParameters
     * @return AuthorisedResponse
     *
     * @throws WorldpayException
     */
    public function authorizePayment(array $paymentParameters)
    {
        return $this->paymentAuthorizer->authorizePayment($paymentParameters);
    }

    /**
     * @param array $paymentParameters
     * @return AuthorisedResponse
     *
     * @throws WorldpayException
     */
    public function completePaymentAuthorization(array $paymentParameters)
    {
        return $this->paymentAuthorizer->authorize3DSecure($paymentParameters);
    }

    /**
     * @param array $paymentParameters
     * @return CaptureResponse
     *
     * @throws WorldpayException
     */
    public function capturePayment(array $paymentParameters)
    {
        return $this->paymentModifier->capturePayment($paymentParameters);
    }

    public function parseNotification(string $notification): NotificationResponse
    {
        return NotificationResponse::fromRawNotification($notification);
    }
}
