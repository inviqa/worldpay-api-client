<?php

namespace Inviqa\Worldpay\Api\Request;

use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Additional3DSData;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Additional3DSData\ChallengeWindowSize;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Additional3DSData\DfReferenceId;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Amount;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Amount\CurrencyCode;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Amount\Exponent;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Amount\Value;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\DeviceSession;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\DeviceSession\SessionId;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Dynamic3DS;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Dynamic3DS\OverrideAdvice;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\FraudSightData;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\FraudSightData\CustomField\CustomField;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\FraudSightData\CustomField\Value as CustomValue;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\FraudSightData\CustomNumericFields;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\FraudSightData\CustomStringFields;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\FraudSightData\ShopperFields;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\FraudSightData\ShopperFields\BirthDate;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\FraudSightData\ShopperFields\BirthDate\Date;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\FraudSightData\ShopperFields\BirthDate\Date\DayOfMonth;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\FraudSightData\ShopperFields\BirthDate\Date\Month;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\FraudSightData\ShopperFields\BirthDate\Date\Year;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\FraudSightData\ShopperFields\ShopperAddress;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\FraudSightData\ShopperFields\ShopperAddress\Address as ShopperFieldsAddress;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\FraudSightData\ShopperFields\ShopperAddress\Address\Address1;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\FraudSightData\ShopperFields\ShopperAddress\Address\Address2;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\FraudSightData\ShopperFields\ShopperAddress\Address\Address3;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\FraudSightData\ShopperFields\ShopperAddress\Address\City as ShopperCity;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\FraudSightData\ShopperFields\ShopperAddress\Address\CountryCode as ShopperCountryCode;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\FraudSightData\ShopperFields\ShopperAddress\Address\TelephoneNumber as ShopperTelephoneNumber;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\FraudSightData\ShopperFields\ShopperId;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\FraudSightData\ShopperFields\ShopperName;
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
use Inviqa\Worldpay\Config;

class AuthoriseRequestTreeBuilder
{
    /**
     * @var Config
     */
    private $config;

    /**
     * @var array
     */
    private $parameters;

    public function __construct(array $parameters, Config $config)
    {
        $this->parameters = $parameters;
        $this->config = $config;
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
                new CountryCode(strtoupper($this->parameters['countryCode'])),
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
                new CountryCode(strtoupper($shippingAddress['countryCode'])),
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

        if (array_key_exists('dfReferenceId', $parameters)) {
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

        if (!empty($parameters['fsSession'])) {
            $order = $order->withFraudsightData(
                $this->buildFraudsightData($parameters)
            );
            $order = $order->withFraudsightSession(
                new DeviceSession(
                    new SessionId($parameters['fsSession'])
                )
            );
        }

        return $order;
    }

    /**
     * @param array $parameters
     *
     * @return FraudSightData
     */
    public function buildFraudsightData(array $parameters)
    {
        $birthday = null;
        if (!empty($parameters['birthday']['day'])) {
            $birthday = new BirthDate(
                new Date(
                    new DayOfMonth(!empty($parameters['birthday']['day']) ? $parameters['birthday']['day'] : ''),
                    new Month(!empty($parameters['birthday']['month']) ? $parameters['birthday']['month'] : ''),
                    new Year(!empty($parameters['birthday']['year']) ? $parameters['birthday']['year'] : '')
                )
            );
        }

        return new FraudSightData(
            $this->buildCustomStringFields(),
            $this->buildCustomNumericFields(),
            new ShopperFields(
                new ShopperName($parameters['firstName'] .' ' . $parameters['lastName']),
                new ShopperId($parameters['customerId']),
                $birthday,
                new ShopperAddress(
                    new ShopperFieldsAddress(
                        new ShopperFieldsAddress\FirstName($parameters['firstName']),
                        new ShopperFieldsAddress\LastName($parameters['lastName']),
                        new Address1($parameters['address1']),
                        new Address2($parameters['address2']),
                        new Address3($parameters['address3']),
                        new ShopperFieldsAddress\PostalCode($parameters['postalCode']),
                        new ShopperCity($parameters['city']),
                        new ShopperCountryCode(strtoupper($parameters['countryCode'])),
                        new ShopperTelephoneNumber($parameters['telephoneNumber'])
                    )
                )
            )
        );
    }

    /**
     * @return CustomStringFields
     *
     * @throws \Inviqa\Worldpay\Api\Exception\InvalidRequestParameterException
     */
    public function buildCustomStringFields()
    {
        return new CustomStringFields(
            $this->config->sendEmptyFraudsightFields(),
            new CustomField('customStringField1', new CustomValue($this->parameters['shippingMethod'])),
            new CustomField('customStringField2', new CustomValue($this->parameters['productRisk'] ? 'High' : 'normal')),
            new CustomField('customStringField3', new CustomValue('')),
            new CustomField('customStringField4', new CustomValue($this->parameters['checkoutMethod'])),
            new CustomField('customStringField5', new CustomValue($this->parameters['orderSource'])),
            new CustomField('customStringField6', new CustomValue($this->parameters['paymentSubtype'] ?? '')),
            new CustomField('customStringField7', new CustomValue('')),
            new CustomField('customStringField8', new CustomValue('')),
            new CustomField('customStringField9', new CustomValue('')),
            new CustomField('customStringField10', new CustomValue(''))
        );
    }

    /**
     * @return CustomNumericFields
     *
     * @throws \Inviqa\Worldpay\Api\Exception\InvalidRequestParameterException
     */
    public function buildCustomNumericFields()
    {
        return new CustomNumericFields(
            $this->config->sendEmptyFraudsightFields(),
            new CustomField('customNumericField1', new CustomValue($this->parameters['ageOfAccount'])),
            new CustomField('customNumericField2', new CustomValue($this->parameters['timeSinceLastOrder'])),
            new CustomField('customNumericField3', new CustomValue($this->parameters['numberPurchases'])),
            new CustomField('customNumericField4', new CustomValue($this->parameters['numberStyles'])),
            new CustomField('customNumericField5', new CustomValue($this->parameters['numberSkus'])),
            new CustomField('customNumericField6', new CustomValue($this->parameters['numberUnits'])),
            new CustomField('customNumericField7', new CustomValue($this->parameters['numberHighRiskUnits'])),
            new CustomField('customNumericField8', new CustomValue('')),
            new CustomField('customNumericField9', new CustomValue('')),
            new CustomField('customNumericField10', new CustomValue(''))
        );
    }

}
