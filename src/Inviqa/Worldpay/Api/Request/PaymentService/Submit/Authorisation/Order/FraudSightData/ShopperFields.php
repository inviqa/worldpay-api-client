<?php

namespace Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\FraudSightData;

use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\FraudSightData\ShopperFields\BirthDate;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\FraudSightData\ShopperFields\ShopperAddress;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\FraudSightData\ShopperFields\ShopperId;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\FraudSightData\ShopperFields\ShopperName;
use Inviqa\Worldpay\Api\XmlNodeDefaults;

class ShopperFields extends XmlNodeDefaults
{
    private $shopperName;
    private $shopperId;
    private $birthDate;
    private $shopperAddress;

    public function __construct(
        ShopperName $shopperName,
        ShopperId $shopperId,
        ?BirthDate $birthDate,
        ShopperAddress $shopperAddress
    ) {
        $this->shopperName = $shopperName;
        $this->shopperId = $shopperId;
        $this->birthDate = $birthDate;
        $this->shopperAddress = $shopperAddress;
    }

    public function xmlChildren()
    {
        return [
            $this->shopperName,
            $this->shopperId,
            $this->birthDate,
            $this->shopperAddress
        ];
    }
}
