<?php

namespace Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails;

use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\Session\Id;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\Session\ShopperIPAddress;
use Inviqa\Worldpay\Api\XmlNodeDefaults;

class Session extends XmlNodeDefaults
{
    private $shopperIPAddress;
    private $id;

    public function __construct(Id $id)
    {
        $this->id = $id;
    }

    public function withShopperIPAddress(ShopperIPAddress $shopperIPAddress): self
    {
        $instance = clone $this;
        $instance->shopperIPAddress = $shopperIPAddress;

        return $instance;
    }

    public function xmlChildren()
    {
        return [
            $this->shopperIPAddress,
            $this->id,
        ];
    }
}
