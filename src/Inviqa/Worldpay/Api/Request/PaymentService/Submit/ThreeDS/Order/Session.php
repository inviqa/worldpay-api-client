<?php

namespace Inviqa\Worldpay\Api\Request\PaymentService\Submit\ThreeDS\Order;


use Inviqa\Worldpay\Api\Request\PaymentService\Submit\ThreeDS\Order\Session\Id;
use Inviqa\Worldpay\Api\XmlNodeDefaults;

class Session extends XmlNodeDefaults
{
    private $id;

    public function __construct(
        Id $id
    )
    {
        $this->id = $id;
    }

    public function xmlChildren()
    {
        return [
            $this->id,
        ];
    }
}
