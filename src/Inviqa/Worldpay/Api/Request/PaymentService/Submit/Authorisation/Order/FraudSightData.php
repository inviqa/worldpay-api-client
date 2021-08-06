<?php

namespace Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order;

use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\FraudSightData\CustomNumericFields;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\FraudSightData\CustomStringFields;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\FraudSightData\ShopperFields;
use Inviqa\Worldpay\Api\XmlNodeDefaults;

class FraudSightData extends XmlNodeDefaults
{
    private $customStringFields;
    private $customNumericFields;
    private $shopperFields;

    public function __construct(
        CustomStringFields $customStringFields,
        CustomNumericFields $customNumericFields,
        ShopperFields $shopperFields
    ) {
        $this->customStringFields = $customStringFields;
        $this->customNumericFields = $customNumericFields;
        $this->shopperFields = $shopperFields;
    }

    public function xmlChildren()
    {
        return [
            $this->customStringFields,
            $this->customNumericFields,
            $this->shopperFields,
        ];
    }

    public function xmlLabel()
    {
        return 'FraudSightData';
    }
}