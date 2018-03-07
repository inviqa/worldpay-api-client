<?php

namespace Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\CseData\CardAddress;

use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\CseData\CardAddress\Address\AddressOne;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\CseData\CardAddress\Address\AddressThree;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\CseData\CardAddress\Address\AddressTwo;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\CseData\CardAddress\Address\City;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\CseData\CardAddress\Address\CountryCode;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\CseData\CardAddress\Address\PostalCode;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\CseData\CardAddress\Address\State;
use Inviqa\Worldpay\Api\XmlNodeDefaults;

class Address extends XmlNodeDefaults
{
    private $addressOne;
    private $addressTwo;
    private $addressThree;
    private $postalCode;
    private $city;
    private $state;
    private $countryCode;

    public function __construct(
        AddressOne $addressOne,
        AddressTwo $addressTwo,
        AddressThree $addressThree,
        PostalCode $postalCode,
        City $city,
        State $state,
        CountryCode $countryCode
    ) {
        $this->addressOne = $addressOne;
        $this->addressTwo = $addressTwo;
        $this->addressThree = $addressThree;
        $this->postalCode = $postalCode;
        $this->city = $city;
        $this->state = $state;
        $this->countryCode = $countryCode;
    }

    public function xmlChildren()
    {
        return [
            $this->addressOne,
            $this->addressTwo,
            $this->addressThree,
            $this->postalCode,
            $this->city,
            $this->state,
            $this->countryCode,
        ];
    }
}
