<?php

namespace Inviqa\Worldpay\Api\Request\PaymentService\Submit\ThreeDS\Order;


use Inviqa\Worldpay\Api\Request\PaymentService\Submit\ThreeDS\Order\PaymentDetails\Session\Id;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\ThreeDS\Order\PaymentDetails\Session\ShopperIPAddress;
use Inviqa\Worldpay\Api\XmlNodeDefaults;

class Session extends XmlNodeDefaults
{
    private $shopperIPAddress;
    private $id;

    public function __construct(
        ShopperIPAddress $shopperIPAddress,
        Id $id
    )
    {
        $this->shopperIPAddress = $shopperIPAddress;
        $this->id = $id;
    }

    public function xmlChildren()
    {
        return [
            $this->shopperIPAddress,
            $this->id,
        ];
    }
}
