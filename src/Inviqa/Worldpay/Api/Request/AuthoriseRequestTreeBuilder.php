<?php

namespace Inviqa\Worldpay\Api\Request;

use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Additional3DSData;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Additional3DSData\ChallengePreference;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Additional3DSData\ChallengeWindowSize;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Additional3DSData\DfReferenceId;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Amount;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Amount\CurrencyCode;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Amount\Exponent;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Amount\Value;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Dynamic3DS;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Dynamic3DS\OverrideAdvice;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\HcgAdditionalData;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Param\Name;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Param\Param;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Param\Value as ParamValue;
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
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\ShippingAddress;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Shopper;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Shopper\Browser;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Shopper\Browser\AcceptHeader;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Shopper\Browser\UserAgentHeader;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Shopper\ShopperEmailAddress;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Order;

class AuthoriseRequestTreeBuilder
{
    /**
     * @var array
     */
    private $parameters;

    public function __construct(array $parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * @return Amount
     * @throws \Inviqa\Worldpay\Api\Exception\InvalidRequestParameterException
     */
    public function buildAmount()
    {
        return new Amount(
            new CurrencyCode($this->parameters['currencyCode']),
            new Exponent($this->parameters['exponent']),
            new Value($this->parameters['value'])
        );
    }

    /**
     * @return CardAddress
     * @throws \Inviqa\Worldpay\Api\Exception\InvalidRequestParameterException
     */
    public function buildCardAddress()
    {
        return new CardAddress(
            new CardAddress\Address(
                new FirstName($this->parameters['firstName']),
                new LastName($this->parameters['lastName']),
                new AddressOne($this->parameters['address1']),
                new AddressTwo($this->parameters['address2']),
                new AddressThree($this->parameters['address3']),
                new PostalCode($this->parameters['postalCode']),
                new City($this->parameters['city']),
                new State($this->parameters['state']),
                new CountryCode($this->parameters['countryCode']),
                new TelephoneNumber($this->parameters['telephoneNumber'])
            )
        );
    }

    /**
     * @return Shopper
     * @throws \Inviqa\Worldpay\Api\Exception\InvalidRequestParameterException
     */
    public function buildShopper()
    {
        $browser = new Browser(
            new AcceptHeader($this->parameters['acceptHeader']),
            new UserAgentHeader($this->parameters['userAgentHeader'])
        );
        return new Shopper(
            new ShopperEmailAddress($this->parameters['email']),
            $browser
        );
    }

    /**
     * @return HcgAdditionalData
     * @throws \Inviqa\Worldpay\Api\Exception\InvalidRequestParameterException
     */
    public function buildHcgAdditionalData()
    {
        return new HcgAdditionalData(
            new Param(new Name('RGProfileID'), new ParamValue($this->parameters['RGProfileID'])),
            new Param(new Name('xField1'), new ParamValue($this->parameters['shippingMethod'])),
            new Param(new Name('xField2'), new ParamValue($this->parameters['productRisk'] ? 'High' : 'normal')),
            new Param(new Name('xField3'), new ParamValue('')),
            new Param(new Name('xField4'), new ParamValue($this->parameters['checkoutMethod'])),
            new Param(new Name('xField5'), new ParamValue($this->parameters['orderSource'])),
            new Param(new Name('xField6'), new ParamValue($this->parameters['paymentSubtype'] ?? '')),
            new Param(new Name('nField1'), new ParamValue($this->parameters['ageOfAccount'])),
            new Param(new Name('nField2'), new ParamValue($this->parameters['timeSinceLastOrder'])),
            new Param(new Name('nField3'), new ParamValue($this->parameters['numberPurchases'])),
            new Param(new Name('nField4'), new ParamValue($this->parameters['numberStyles'])),
            new Param(new Name('nField5'), new ParamValue($this->parameters['numberSkus'])),
            new Param(new Name('nField6'), new ParamValue($this->parameters['numberUnits'])),
            new Param(new Name('nField7'), new ParamValue($this->parameters['numberHighRiskUnits']))
        );
    }

    /**
     * @param array $shippingAddress
     *
     * @return ShippingAddress
     * @throws \Inviqa\Worldpay\Api\Exception\InvalidRequestParameterException
     */
    public function buildShippingAddress(array $shippingAddress)
    {
        return new ShippingAddress(
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
        );
    }

    /**
     * @param array $parameters
     * @param Order $order
     *AuthorizeRequestFactoryApplePay
     * @return Order
     * @throws \Inviqa\Worldpay\Api\Exception\InvalidRequestParameterException
     */
    public function buildAdditionalOrderDetails(array $parameters, Order $order)
    {
        if ($shippingAddress = $parameters['shippingAddress']) {
            $order = $order->withShippingAddress(
                $this->buildShippingAddress($shippingAddress)
            );
        }

        if (!empty($parameters['dfReferenceId'])) {
            $order = $order->with3DSFlex(
                new Additional3DSData(
                    new DfReferenceId($parameters['dfReferenceId']),
                    new ChallengeWindowSize('fullPage')
                )
            );
        } elseif ($parameters['dynamic3DS']) {
            $dynamic3DSOverride = $parameters['dynamic3DSOverride'] ? "do3DS" : "no3DS";
            $order = $order->withDynamic3DS(
                new Dynamic3DS(new OverrideAdvice($dynamic3DSOverride))
            );
        }

        return $order;
    }
}