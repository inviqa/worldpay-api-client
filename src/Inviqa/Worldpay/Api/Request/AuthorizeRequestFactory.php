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
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\CseData\CardAddress\Address\PostalCode;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\CseData\CardAddress\Address\State;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\CseData\CardAddress\Address\TelephoneNumber;
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
        'telephoneNumber' => "",
        'shopperIPAddress' => "",
        'email' => "",
        'sessionId' => "",
        'acceptHeader' => "",
        'userAgentHeader' => "",
        'dynamic3DS' => false,
        'rgProfileId'         => "",
        'shippingMethod'      => "",
        'checkoutMethod'      => "",
        'ageOfAccount'        => "",
        'timeSinceLastOrder'  => "",
        'numberPurchases'     => "",
        'productRisk'         => false,
        'productType'         => "",
        'numberStyles'        => "",
        'numberSkus'          => "",
        'numberUnits'         => "",
        'numberHighRiskUnits' => "",
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
            new Param(new Name('rgProfileId'), new ParamValue($parameters['rgProfileId'])),
            new Param(new Name('xField1'), new ParamValue($parameters['shippingMethod'])),
            new Param(new Name('xField2'), new ParamValue($parameters['productRisk'] ? 'High' : 'normal')),
            new Param(new Name('xField3'), new ParamValue($parameters['productType'])),
            new Param(new Name('xField4'), new ParamValue($parameters['checkoutMethod'])),
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
}
