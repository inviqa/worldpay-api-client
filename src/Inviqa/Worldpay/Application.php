<?php

namespace Inviqa\Worldpay;

use Inviqa\Worldpay\Api\Client;
use Inviqa\Worldpay\Api\Client\ClientFactory;
use Inviqa\Worldpay\Api\Exception\WorldpayException;
use Inviqa\Worldpay\Api\PaymentAuthorizer;
use Inviqa\Worldpay\Api\PaymentModifier;
use Inviqa\Worldpay\Api\Request\AuthorizeRequestFactory;
use Inviqa\Worldpay\Api\Request\AuthorizeRequestFactoryApplePay;
use Inviqa\Worldpay\Api\Request\CancelRequestFactory;
use Inviqa\Worldpay\Api\Request\CaptureRequestFactory;
use Inviqa\Worldpay\Api\Request\RefundRequestFactory;
use Inviqa\Worldpay\Api\Request\ThreeDSRequestFactory;
use Inviqa\Worldpay\Api\Response\AuthorisedResponse;
use Inviqa\Worldpay\Api\Response\CancelResponse;
use Inviqa\Worldpay\Api\Response\CaptureResponse;
use Inviqa\Worldpay\Api\Response\RefundResponse;
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

        $this->paymentAuthorizer = PaymentAuthorizer::worldpayAuthorizer(
            new AuthorizeRequestFactory(),
            new ThreeDSRequestFactory(),
            new XmlNodeConverter(
                new Writer()
            ),
            $this->client
        );

        $this->paymentAuthorizerApplePay = PaymentAuthorizer::applePayAuthorizer(
            new AuthorizeRequestFactoryApplePay(),
            new XmlNodeConverter(
                new Writer()
            ),
            $this->client
        );

        $this->paymentModifier = new PaymentModifier(
            new CaptureRequestFactory(),
            new RefundRequestFactory(),
            new CancelRequestFactory(),
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
    public function authorizeApplePayPayment(array $paymentParameters)
    {
        return $this->paymentAuthorizerApplePay->authorizePayment($paymentParameters);
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

    /**
     * @param array $paymentParameters
     * @return RefundResponse
     *
     * @throws WorldpayException
     */
    public function refundPayment(array $paymentParameters)
    {
        return $this->paymentModifier->refundPayment($paymentParameters);
    }

    /**
     * @param array $paymentParameters
     * @return CancelResponse
     *
     * @throws WorldpayException
     */
    public function cancelPayment(array $paymentParameters)
    {
        return $this->paymentModifier->cancelPayment($paymentParameters);
    }

    /**
     * @param string $notification
     *
     * @return NotificationResponse
     */
    public function parseNotification(string $notification): NotificationResponse
    {
        return NotificationResponse::fromRawNotification($notification);
    }
}
