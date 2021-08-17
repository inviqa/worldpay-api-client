<?php

namespace Inviqa\Worldpay\Api\Request;

use Inviqa\Worldpay\Api\Exception\InvalidRequestParameterException;
use Inviqa\Worldpay\Api\Request\PaymentService\MerchantCode;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\AuthorisationOrder;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\AuthorisationOrderApplePay;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\ApplePaySSL;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\ApplePaySSL\Data;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\ApplePaySSL\Header;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\ApplePaySSL\Header\EphemeralPublicKey;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\ApplePaySSL\Header\PublicKeyHash;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\ApplePaySSL\Header\TransactionId;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Description;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\OrderCode;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\ApplePaySSL\Signature;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\ApplePaySSL\Version as ApplePayVersion;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetailsApplePay;
use Inviqa\Worldpay\Api\Request\PaymentService\Version;
use Inviqa\Worldpay\Config;

class AuthorizeRequestFactoryApplePay implements RequestFactory
{
    /**
     * @var Config
     */
    private $config;

    private $defaultApplePayParameters = [
        'signature' => "dummy signature",
        'applePayVersion' => "dummy version",
        'ephemeralPublicKey' => "dummy public key",
        'publicKeyHash' => "dummy hash",
        'transactionId' => "123456",
    ];

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

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
        $parameters += $this->defaultApplePayParameters;

        $treeBuilder = new AuthoriseRequestTreeBuilder($parameters, $this->config);

        $orderCode = new OrderCode($parameters['orderCode']);
        $description = new Description($parameters['description']);
        $amount = $treeBuilder->buildAmount($parameters);

        $ephemeralPublicKey = new EphemeralPublicKey($parameters['ephemeralPublicKey']);
        $publicKeyHash = new PublicKeyHash($parameters['publicKeyHash']);
        $transactionId = new TransactionId($parameters['transactionId']);
        $header = new Header(
            $ephemeralPublicKey,
            $publicKeyHash,
            $transactionId
        );
        $signature = new Signature($parameters['signature']);
        $version = new ApplePayVersion($parameters['applePayVersion']);
        $data = new Data($parameters['encryptedData']);
        $applePaySSL = new ApplePaySSL(
            $header,
            $signature,
            $version,
            $data
        );

        $paymentDetails = new PaymentDetailsApplePay($applePaySSL);
        $shopper = $treeBuilder->buildShopper();
        $hcgAdditionalData = $treeBuilder->buildHcgAdditionalData();

        $order = new AuthorisationOrder(
            $orderCode,
            $description,
            $amount,
            $paymentDetails,
            $shopper,
            $hcgAdditionalData
        );
        $order = $treeBuilder->buildAdditionalOrderDetails($parameters, $order);

        $paymentService = new PaymentService(
            new Version($parameters['version']),
            new MerchantCode($parameters['merchantCode']),
            new Submit($order)
        );

        return $paymentService;
    }
}
