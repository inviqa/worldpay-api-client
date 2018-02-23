<?php

namespace Inviqa\Worldpay\Api\Request\Order\PaymentDetails;

use Inviqa\Worldpay\Api\Request\Order\PaymentDetails\Session\Id;
use Inviqa\Worldpay\Api\Request\Order\PaymentDetails\Session\ShopperIPAddress;

class Session
{
    private $shopperIPAddress;
    private $id;

    public function __construct(
        ShopperIPAddress $shopperIPAddress,
        Id $id
    ) {
        $this->shopperIPAddress = $shopperIPAddress;
        $this->id = $id;
    }
}
