<?php

namespace Inviqa\Worldpay\Api\Request;


use Inviqa\Worldpay\Api\Exception\InvalidRequestParameterException;
use Inviqa\Worldpay\Api\Request\PaymentService\MerchantCode;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\AuthorisationOrder;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\AuthorisationOrderGooglePay;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Amount;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Amount\CurrencyCode;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Amount\Exponent;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Amount\Value;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Description;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Dynamic3DS;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Dynamic3DS\OverrideAdvice;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\OrderCode;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\CseData;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\CseData\EncryptedData;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\PayWithGoogleSSL;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\PayWithGoogleSSL\ProtocolVersion;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\PayWithGoogleSSL\Signature;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\PayWithGoogleSSL\SignedMessage;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\Session;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetailsGooglePay;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Shopper\ShopperEmailAddress;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\ShopperBasic;
use Inviqa\Worldpay\Api\Request\PaymentService\Version;

class AuthorizeRequestFactoryGooglePay implements RequestFactory
{
    private $defaultGooglePayParameters = [
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
        if (!empty($parameters['shippingAddress'])) {
            $parameters['shippingAddress'] += AuthorizeRequestFactory::DEFAULT_ADDRESS_PARAMETERS;
        }
        $parameters += AuthorizeRequestFactory::DEFAULT_PARAMETERS;
        $parameters += $this->defaultGooglePayParameters;
        $treeBuilder = new AuthoriseRequestTreeBuilder($parameters);

        $orderCode = new OrderCode($parameters['orderCode']);
        $description = new Description($parameters['description']);
        $amount = $treeBuilder->buildAmount($parameters);
        $protocolVersion = new ProtocolVersion($parameters['protocolVersion']);
        $signature = new Signature($parameters['signature']);
        $signedMessage = new SignedMessage($parameters['encryptedData']);
        $googlePaySSL = new PayWithGoogleSSL(
            $protocolVersion,
            $signature,
            $signedMessage
        );

        $paymentDetails = new PaymentDetailsGooglePay($googlePaySSL);
        $shopper = $treeBuilder->buildShopper();

        $hcgAdditionalData = $treeBuilder->buildHcgAdditionalData();

        $order = new AuthorisationOrderGooglePay(
            $orderCode,
            $description,
            $amount,
            $paymentDetails,
            $shopper,
            $hcgAdditionalData
        );

        $order = $treeBuilder->buildAdditionalOrderDetails($parameters, $order);

        return new PaymentService(
            new Version($parameters['version']),
            new MerchantCode($parameters['merchantCode']),
            new Submit($order)
        );
    }
}