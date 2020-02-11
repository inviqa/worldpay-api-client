<?php

namespace Inviqa\Worldpay\Api\Request;

use http\Header;
use Inviqa\Worldpay\Api\Exception\InvalidRequestParameterException;
use Inviqa\Worldpay\Api\Request\ApplePayPaymentService\Submit\Authorisation\AuthorisationOrder as ApplePayAuthorisationOrder;
use Inviqa\Worldpay\Api\Request\ApplePayPaymentService\Submit\Authorisation\Order\Amount as ApplePayAmount;
use Inviqa\Worldpay\Api\Request\ApplePayPaymentService\Submit\Authorisation\Order\Amount\CurrencyCode as ApplePayCurrencyCode;
use Inviqa\Worldpay\Api\Request\ApplePayPaymentService\Submit\Authorisation\Order\Amount\Exponent as ApplePayExponent;
use Inviqa\Worldpay\Api\Request\ApplePayPaymentService\Submit\Authorisation\Order\Amount\Value as ApplePayValue;
use Inviqa\Worldpay\Api\Request\ApplePayPaymentService\Submit\Authorisation\Order\PaymentDetails\ApplePaySSL\Header as ApplePayHeader;
use Inviqa\Worldpay\Api\Request\ApplePayPaymentService\Submit\Authorisation\Order\Description as ApplePayDescription;
use Inviqa\Worldpay\Api\Request\ApplePayPaymentService\Submit\Authorisation\Order\OrderCode as ApplePayOrderCode;
use Inviqa\Worldpay\Api\Request\ApplePayPaymentService\Submit\Authorisation\Order\PaymentDetails as ApplePayPaymentDetails;
use Inviqa\Worldpay\Api\Request\ApplePayPaymentService\Submit\Authorisation\Order\PaymentDetails\ApplePaySSL;
use Inviqa\Worldpay\Api\Request\ApplePayPaymentService\Submit\Authorisation\Order\PaymentDetails\ApplePaySSL\Data;
use Inviqa\Worldpay\Api\Request\ApplePayPaymentService\Submit\Authorisation\Order\PaymentDetails\ApplePaySSL\Header\EphemeralPublicKey;
use Inviqa\Worldpay\Api\Request\ApplePayPaymentService\Submit\Authorisation\Order\PaymentDetails\ApplePaySSL\Header\PublicKeyHash;
use Inviqa\Worldpay\Api\Request\ApplePayPaymentService\Submit\Authorisation\Order\PaymentDetails\ApplePaySSL\Header\TransactionId;
use Inviqa\Worldpay\Api\Request\ApplePayPaymentService\Submit\Authorisation\Order\PaymentDetails\ApplePaySSL\Signature;
use Inviqa\Worldpay\Api\Request\ApplePayPaymentService\Submit\Authorisation\Order\PaymentDetails\ApplePaySSL\Version as ApplePayVersion;
use Inviqa\Worldpay\Api\Request\ApplePayPaymentService\Submit\Authorisation\Order\Shopper as ApplePayShopper;
use Inviqa\Worldpay\Api\Request\ApplePayPaymentService\Submit\Authorisation\Order\Shopper\ShopperEmailAddress;
use Inviqa\Worldpay\Api\Request\PaymentService\MerchantCode;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\AuthorisationOrder;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Amount;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Amount\CurrencyCode;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Amount\Exponent;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Amount\Value;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Description;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Dynamic3DS;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Dynamic3DS\OverrideAdvice;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\HcgAdditionalData;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\OrderCode;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Param\Name;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Param\Param;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Param\Value as ParamValue;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\CseData;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\CseData\CardAddress;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\CseData\CardAddress\Address\AddressOne;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\CseData\CardAddress\Address\AddressThree;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\CseData\CardAddress\Address\AddressTwo;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\CseData\CardAddress\Address\City;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\CseData\CardAddress\Address\CountryCode;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\CseData\CardAddress\Address\FirstName;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\CseData\CardAddress\Address\LastName;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\CseData\CardAddress\Address\PostalCode;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\CseData\CardAddress\Address\State;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\CseData\CardAddress\Address\TelephoneNumber;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\CseData\EncryptedData;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\Session;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\ShippingAddress;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Shopper;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Shopper\Browser;
use Inviqa\Worldpay\Api\Request\PaymentService\Version;

class AuthorizeRequestFactory
{
    private $defaultParameters = [
        'version' => "1.4",
        'orderCode' => "",
        'description' => "",
        'currencyCode' => "",
        'exponent' => "2",
        'value' => "",
        'encryptedData' => "",
        'address1' => "",
        'address2' => "",
        'address3' => "",
        'postalCode' => "",
        'city' => "",
        'state' => "",
        'countryCode' => "",
        'telephoneNumber' => "",
        'shopperIPAddress' => "",
        'email' => "",
        'sessionId' => "",
        'acceptHeader' => "",
        'userAgentHeader' => "",
        'dynamic3DS' => false,
        'RGProfileID' => "",
        'shippingMethod' => "",
        'checkoutMethod' => "",
        'orderSource' => "",
        'ageOfAccount' => "",
        'timeSinceLastOrder' => "",
        'numberPurchases' => "",
        'productRisk' => false,
        'numberStyles' => "",
        'numberSkus' => "",
        'numberUnits' => "",
        'numberHighRiskUnits' => "",
        'shippingAddress' => null,
    ];

    private $defaultAddressParameters = [
        'address1' => "",
        'address2' => "",
        'address3' => "",
        'postalCode' => "",
        'city' => "",
        'state' => "",
        'countryCode' => "",
        'telephoneNumber' => "",
    ];

    private $defaultApplePayParameters = [
        'version' => "1.4",
        'orderCode' => "",
        'description' => "",
        'currencyCode' => "",
        'exponent' => "2",
        'value' => "",
        'data' => "",
        'signature' => "dummy signature",
        'version' => "dummy version",
        'ephemeralPublicKey' => "dummy public key",
        'publicKeyHash' => "dummy hash",
        'transactionId' => "123456",
    ];

    /**
     * @param array $parameters
     * @return PaymentService
     *
     * @throws InvalidRequestParameterException
     */
    public function buildFromRequestParameters(array $parameters): PaymentService
    {
        if (!empty($parameters['shippingAddress'])) {
            $parameters['shippingAddress'] += $this->defaultAddressParameters;
        }
        $parameters += $this->defaultParameters;

        $orderCode = new OrderCode($parameters['orderCode']);
        $description = new Description($parameters['description']);
        $amount = new Amount(
            new CurrencyCode($parameters['currencyCode']),
            new Exponent($parameters['exponent']),
            new Value($parameters['value'])
        );
        $encryptedData = new EncryptedData($parameters['encryptedData']);
        $cardAddress = new CardAddress(
            new CardAddress\Address(
                new FirstName($parameters['firstName']),
                new LastName($parameters['lastName']),
                new AddressOne($parameters['address1']),
                new AddressTwo($parameters['address2']),
                new AddressThree($parameters['address3']),
                new PostalCode($parameters['postalCode']),
                new City($parameters['city']),
                new State($parameters['state']),
                new CountryCode($parameters['countryCode']),
                new TelephoneNumber($parameters['telephoneNumber'])
            )
        );
        $cseData = new CseData($encryptedData, $cardAddress);
        $session = new Session(
            new Session\Id($parameters['sessionId'])
        );

        if ($parameters['shopperIPAddress']) {
            $session = $session->withShopperIPAddress(new Session\ShopperIPAddress($parameters['shopperIPAddress']));
        }

        $paymentDetails = new PaymentDetails($cseData, $session);
        $browser = new Browser(
            new Browser\AcceptHeader($parameters['acceptHeader']),
            new Browser\UserAgentHeader($parameters['userAgentHeader'])
        );
        $shopper = new Shopper(
            new Shopper\ShopperEmailAddress($parameters['email']),
            $browser
        );

        $hcgAdditionalData = new HcgAdditionalData(
            new Param(new Name('RGProfileID'), new ParamValue($parameters['RGProfileID'])),
            new Param(new Name('xField1'), new ParamValue($parameters['shippingMethod'])),
            new Param(new Name('xField2'), new ParamValue($parameters['productRisk'] ? 'High' : 'normal')),
            new Param(new Name('xField3'), new ParamValue('')),
            new Param(new Name('xField4'), new ParamValue($parameters['checkoutMethod'])),
            new Param(new Name('xField5'), new ParamValue($parameters['orderSource'])),
            new Param(new Name('nField1'), new ParamValue($parameters['ageOfAccount'])),
            new Param(new Name('nField2'), new ParamValue($parameters['timeSinceLastOrder'])),
            new Param(new Name('nField3'), new ParamValue($parameters['numberPurchases'])),
            new Param(new Name('nField4'), new ParamValue($parameters['numberStyles'])),
            new Param(new Name('nField5'), new ParamValue($parameters['numberSkus'])),
            new Param(new Name('nField6'), new ParamValue($parameters['numberUnits'])),
            new Param(new Name('nField7'), new ParamValue($parameters['numberHighRiskUnits']))
        );

        $order = new AuthorisationOrder(
            $orderCode,
            $description,
            $amount,
            $paymentDetails,
            $shopper,
            $hcgAdditionalData
        );

        if ($shippingAddress = $parameters['shippingAddress']) {
            $order = $order->withShippingAddress(
                new ShippingAddress(
                    new CardAddress\Address(
                        new FirstName($shippingAddress['firstName']),
                        new LastName($shippingAddress['lastName']),
                        new AddressOne($shippingAddress['address1']),
                        new AddressTwo($shippingAddress['address2']),
                        new AddressThree($shippingAddress['address3']),
                        new PostalCode($shippingAddress['postalCode']),
                        new City($shippingAddress['city']),
                        new State($shippingAddress['state']),
                        new CountryCode($shippingAddress['countryCode']),
                        new TelephoneNumber($shippingAddress['telephoneNumber'])
                    )
                )
            );
        }

        if ($parameters['dynamic3DS']) {
            $dynamic3DSOverride = $parameters['dynamic3DSOverride'] ? "do3DS" : "no3DS";
            $order = $order->withDynamic3DS(
                new Dynamic3DS(new OverrideAdvice($dynamic3DSOverride))
            );
        }

        $paymentService = new PaymentService(
            new Version($parameters['version']),
            new MerchantCode($parameters['merchantCode']),
            new Submit($order)
        );

        return $paymentService;
    }

    /**
     * @param array $parameters
     *
     * @return PaymentService
     * @throws InvalidRequestParameterException
     */
    public function buildApplePayFromRequestParameters(array $parameters): PaymentService
    {
        if (!empty($parameters['shippingAddress'])) {
            $parameters['shippingAddress'] += $this->defaultAddressParameters;
        }
        $parameters += $this->defaultApplePayParameters;

        $orderCode = new ApplePayOrderCode($parameters['orderCode']);
        $description = new ApplePayDescription($parameters['description']);
        $amount = new ApplePayAmount(
            new ApplePayValue($parameters['value']),
            new ApplePayCurrencyCode($parameters['currencyCode']),
            new ApplePayExponent($parameters['exponent'])
        );
        $ephemeralPublicKey = new EphemeralPublicKey($parameters['ephemeralPublicKey']);
        $publicKeyHash = new PublicKeyHash($parameters['publicKeyHash']);
        $transactonId = new TransactionId($parameters['transactionId']);
        $header = new ApplePayHeader(
            $ephemeralPublicKey,
            $publicKeyHash,
            $transactonId
        );
        $signature = new Signature($parameters['signature']);
        $version = new ApplePayVersion($parameters['version']);
        $data = new Data($parameters['encryptedData']);
        $applePaySSL = new ApplePaySSL(
            $header,
            $signature,
            $version,
            $data
        );
        $paymentDetails = new ApplePayPaymentDetails($applePaySSL);
        $emailAddress = new ShopperEmailAddress($parameters['email']);
        $shopper = new ApplePayShopper($emailAddress);
        $order = new ApplePayAuthorisationOrder(
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
