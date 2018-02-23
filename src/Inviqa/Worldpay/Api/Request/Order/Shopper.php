<?php

namespace Inviqa\Worldpay\Api\Request\Order;

use Inviqa\Worldpay\Api\Request\Order\Shopper\Browser;
use Inviqa\Worldpay\Api\Request\Order\Shopper\ShopperEmailAddress;

class Shopper
{
    private $shopperEmailAddress;
    private $browser;

    public function __construct(
        ShopperEmailAddress $shopperEmailAddress,
        Browser $browser
    ) {
        $this->shopperEmailAddress = $shopperEmailAddress;
        $this->browser = $browser;
    }
}
