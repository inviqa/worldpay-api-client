<?php

namespace Inviqa\Worldpay\Api\Request\PaymentService\Modify;

use Inviqa\Worldpay\Api\XmlNodeDefaults;

class Modify extends XmlNodeDefaults
{
    private $orderModification;

    public function __construct(OrderModification $orderModification)
    {
        $this->orderModification = $orderModification;
    }

    public function xmlChildren()
    {
        return [$this->orderModification];
    }
}
