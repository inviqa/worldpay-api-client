<?php

namespace Inviqa\Worldpay\Api\Request;

use Inviqa\Worldpay\Api\Exception\InvalidRequestParameterException;
use Inviqa\Worldpay\Api\Request\PaymentService\MerchantCode;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\AuthorisationOrderApplePay;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\ApplePaySSL;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\ApplePaySSL\Data;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\ApplePaySSL\Header;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\ApplePaySSL\Header\EphemeralPublicKey;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\ApplePaySSL\Header\PublicKeyHash;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\ApplePaySSL\Header\TransactionId;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Amount;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Amount\CurrencyCode;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Amount\Exponent;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Amount\Value;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Description;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\OrderCode;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\ApplePaySSL\Signature;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\ApplePaySSL\Version as ApplePayVersion;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetailsApplePay;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Shopper\ShopperEmailAddress;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\ShopperBasic;
use Inviqa\Worldpay\Api\Request\PaymentService\Version;

class AuthorizeRequestFactoryApplePay implements RequestFactory
{
    private $defaultApplePayParameters = [
        'version' => "1.4",
        'orderCode' => "",
        'description' => "",
        'currencyCode' => "",
        'exponent' => "2",
        'value' => "",
        'data' => "",
        'signature' => "dummy signature",
        'applePayVersion' => "dummy version",
        'ephemeralPublicKey' => "dummy public key",
        'publicKeyHash' => "dummy hash",
        'transactionId' => "123456",
    ];

    /**
     * @param array $parameters
     *
     * @return PaymentService
     * @throws InvalidRequestParameterException
     */
    public function buildFromRequestParameters(array $parameters): PaymentService
    {
        $parameters += $this->defaultApplePayParameters;
        $orderCode = new OrderCode($parameters['orderCode']);
        $description = new Description($parameters['description']);
        $amount = new Amount(
            new CurrencyCode($parameters['currencyCode']),
            new Exponent($parameters['exponent']),
            new Value($parameters['value'])
        );
        $ephemeralPublicKey = new EphemeralPublicKey($parameters['ephemeralPublicKey']);
        $publicKeyHash = new PublicKeyHash($parameters['publicKeyHash']);
        $transactonId = new TransactionId($parameters['transactionId']);
        $header = new Header(
            $ephemeralPublicKey,
            $publicKeyHash,
            $transactonId
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
        $emailAddress = new ShopperEmailAddress($parameters['email']);
        $shopper = new ShopperBasic($emailAddress);
        $order = new AuthorisationOrderApplePay(
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