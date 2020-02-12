<?php

namespace Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order;

use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Shopper\ShopperEmailAddress;
use Inviqa\Worldpay\Api\XmlNodeDefaults;

class ShopperApplePay extends XmlNodeDefaults
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

    public function xmlLabel()
    {
        return 'shopper';
    }
}
