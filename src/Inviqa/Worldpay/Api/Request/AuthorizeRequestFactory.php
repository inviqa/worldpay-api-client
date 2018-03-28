<?php

namespace Inviqa\Worldpay\Api\Request;

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
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\OrderCode;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\CseData;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\CseData\CardAddress;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\CseData\CardAddress\Address\AddressOne;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\CseData\CardAddress\Address\AddressThree;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\CseData\CardAddress\Address\AddressTwo;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\CseData\CardAddress\Address\City;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\CseData\CardAddress\Address\CountryCode;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\CseData\CardAddress\Address\PostalCode;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\CseData\CardAddress\Address\State;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\CseData\EncryptedData;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\Session;
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
        'shopperIPAddress' => "",
        'email' => "",
        'sessionId' => "",
        'acceptHeader' => "",
        'userAgentHeader' => "",
        'dynamic3DS' => false,
    ];

    public function buildFromRequestParameters(array $parameters): PaymentService
    {
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
                new AddressOne($parameters['address1']),
                new AddressTwo($parameters['address2']),
                new AddressThree($parameters['address3']),
                new PostalCode($parameters['postalCode']),
                new City($parameters['city']),
                new State($parameters['state']),
                new CountryCode($parameters['countryCode'])
            )
        );
        $cseData = new CseData($encryptedData, $cardAddress);
        $session = new Session(
            new Session\ShopperIPAddress($parameters['shopperIPAddress']),
            new Session\Id($parameters['sessionId'])
        );
        $paymentDetails = new PaymentDetails($cseData, $session);
        $browser = new Browser(
            new Browser\AcceptHeader($parameters['acceptHeader']),
            new Browser\UserAgentHeader($parameters['userAgentHeader'])
        );
        $shopper = new Shopper(
            new Shopper\ShopperEmailAddress($parameters['email']),
            $browser
        );
        $dynamic3DSAdvice = "true" == $parameters['dynamic3DS'] ? "do3DS" : "no3DS";
        $dynamic3DS = new Dynamic3DS(new OverrideAdvice($dynamic3DSAdvice));
        $order = new AuthorisationOrder(
            $orderCode,
            $description,
            $amount,
            $paymentDetails,
            $shopper,
            $dynamic3DS
        );

        $paymentService = new PaymentService(
            new Version($parameters['version']),
            new MerchantCode($parameters['merchantCode']),
            new Submit($order)
        );

        return $paymentService;
    }
}
