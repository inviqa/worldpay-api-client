<?php

namespace Inviqa\Worldpay\Api\Request\PaymentService\Submit\Order;

use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Order\Shopper\Browser;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Order\Shopper\ShopperEmailAddress;
use Inviqa\Worldpay\Api\XmlNodeDefaults;

class Shopper extends XmlNodeDefaults
{
    private $shopperEmailAddress;
    private $browser;

    public function __construct(
        ShopperEmailAddress $shopperEmailAddress,
        Browser $browser
    )
    {
        $this->shopperEmailAddress = $shopperEmailAddress;
        $this->browser = $browser;
    }

    public function xmlChildren()
    {
        return [
            $this->shopperEmailAddress,
            $this->browser,
        ];
    }
}
