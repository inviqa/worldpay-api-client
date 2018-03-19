<?php

namespace Inviqa\Worldpay\Api\Request\PaymentService;

use Inviqa\Worldpay\Api\Request\PaymentService\Modify\OrderModification;
use Inviqa\Worldpay\Api\XmlNodeDefaults;

class Modify extends XmlNodeDefaults implements PaymentServiceType
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

    public function xmlLabel()
    {
        return 'modify';
    }
}
