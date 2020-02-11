<?php

namespace Inviqa\Worldpay\Api\Request\ApplePayPaymentService\Submit\Authorisation\Order;

use Inviqa\Worldpay\Api\Request\ApplePayPaymentService\Submit\Authorisation\Order\Shopper\ShopperEmailAddress;
use Inviqa\Worldpay\Api\XmlNodeDefaults;

class Shopper extends XmlNodeDefaults
{
    private $shopperEmailAddress;

    public function __construct(
        ShopperEmailAddress $shopperEmailAddress
    ) {
        $this->shopperEmailAddress = $shopperEmailAddress;
    }

    public function xmlChildren()
    {
        return [
            $this->shopperEmailAddress,
        ];
    }
}
