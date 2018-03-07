<?php

namespace Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation;

use Inviqa\Worldpay\Api\XmlNodeDefaults;

class Authorization extends XmlNodeDefaults
{
    private $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function xmlChildren()
    {
        return [$this->order];
    }
}
