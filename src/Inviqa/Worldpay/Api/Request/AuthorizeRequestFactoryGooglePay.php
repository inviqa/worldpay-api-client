<?php

namespace Inviqa\Worldpay\Api\Request;


use Inviqa\Worldpay\Api\Exception\InvalidRequestParameterException;
use Inviqa\Worldpay\Api\Request\PaymentService\MerchantCode;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\AuthorisationOrderGooglePay;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Amount;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Amount\CurrencyCode;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Amount\Exponent;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Amount\Value;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Description;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\OrderCode;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\PayWithGoogleSSL;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\PayWithGoogleSSL\ProtocolVersion;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\PayWithGoogleSSL\Signature;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\PayWithGoogleSSL\SignedMessage;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetailsGooglePay;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Shopper\ShopperEmailAddress;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\ShopperBasic;
use Inviqa\Worldpay\Api\Request\PaymentService\Version;

class AuthorizeRequestFactoryGooglePay implements RequestFactory
{
    private $defaultGooglePayParameters = [
        'version' => "1.4",
        'orderCode' => "",
        'description' => "",
        'currencyCode' => "",
        'exponent' => "2",
        'value' => "",
        'encryptedData' => "",
        'protocolVersion' => "dummy protocol version",
        'signature' => "dummy signature",
    ];

    /**
     * @param array $parameters
     *
     * @return PaymentService
     * @throws InvalidRequestParameterException
     */
    public function buildFromRequestParameters(array $parameters): PaymentService
    {
        $parameters += $this->defaultGooglePayParameters;
        $orderCode = new OrderCode($parameters['orderCode']);
        $description = new Description($parameters['description']);
        $amount = new Amount(
            new CurrencyCode($parameters['currencyCode']),
            new Exponent($parameters['exponent']),
            new Value($parameters['value'])
        );

        $protocolVersion = new ProtocolVersion($parameters['protocolVersion']);
        $signature = new Signature($parameters['signature']);
        $signedMessage = new SignedMessage($parameters['encryptedData']);
        $googlePaySSL = new PayWithGoogleSSL(
            $protocolVersion,
            $signature,
            $signedMessage
        );

        $paymentDetails = new PaymentDetailsGooglePay($googlePaySSL);
        $emailAddress = new ShopperEmailAddress($parameters['email']);
        $shopper = new ShopperBasic($emailAddress);
        $order = new AuthorisationOrderGooglePay(
            $orderCode,
            $description,
            $amount,
            $paymentDetails,
            $shopper
        );
        $paymentService = new PaymentService(
            new Version($parameters['version']),
            new MerchantCode($parameters['merchantCode']),
            new Submit($order)
        );

        return $paymentService;
    }
}