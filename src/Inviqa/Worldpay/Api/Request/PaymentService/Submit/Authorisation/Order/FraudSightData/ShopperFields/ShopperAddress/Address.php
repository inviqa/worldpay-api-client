<?php

namespace Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\FraudSightData\ShopperFields\ShopperAddress;

use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\FraudSightData\ShopperFields\ShopperAddress\Address\Address1;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\FraudSightData\ShopperFields\ShopperAddress\Address\Address2;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\FraudSightData\ShopperFields\ShopperAddress\Address\Address3;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\FraudSightData\ShopperFields\ShopperAddress\Address\City;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\FraudSightData\ShopperFields\ShopperAddress\Address\CountryCode;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\FraudSightData\ShopperFields\ShopperAddress\Address\FirstName;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\FraudSightData\ShopperFields\ShopperAddress\Address\LastName;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\FraudSightData\ShopperFields\ShopperAddress\Address\PostalCode;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\FraudSightData\ShopperFields\ShopperAddress\Address\TelephoneNumber;
use Inviqa\Worldpay\Api\XmlNodeDefaults;

class Address extends XmlNodeDefaults
{
    private $firstName;
    private $lastName;
    private $address1;
    private $address2;
    private $address3;
    private $postalCode;
    private $city;
    private $countryCode;
    private $telephoneNumber;

    public function __construct(
        FirstName $firstName,
        LastName $lastName,
        Address1 $address1,
        Address2 $address2,
        Address3 $address3,
        PostalCode  $postalCode,
        City $city,
        CountryCode $countryCode,
        TelephoneNumber $telephoneNumber
    ) {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->address1 = $address1;
        $this->address2 = $address2;
        $this->address3 = $address3;
        $this->postalCode = $postalCode;
        $this->city = $city;
        $this->countryCode = $countryCode;
        $this->telephoneNumber = $telephoneNumber;
    }

    public function xmlChildren()
    {
        return [
            $this->firstName,
            $this->lastName,
            $this->address1,
            $this->address2,
            $this->address3,
            $this->postalCode,
            $this->city,
            $this->countryCode,
            $this->telephoneNumber,
        ];
    }
}
