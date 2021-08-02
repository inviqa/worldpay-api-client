<?php

namespace Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order;

use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\FraudSightData\ShopperFields;
use Inviqa\Worldpay\Api\XmlNodeDefaults;

class FraudSightData extends XmlNodeDefaults
{
    private $shopperFields;

    public function __construct(
        ShopperFields $shopperFields
    ) {
        $this->shopperFields = $shopperFields;
    }

    public function xmlChildren()
    {
        return [
            $this->shopperFields,
        ];
    }
}