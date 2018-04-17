<?php

namespace Inviqa\Worldpay\Api\Request\PaymentService\Modify\OrderModification\Cancel;

use Inviqa\Worldpay\Api\Request\PaymentService\Modify\OrderModification;
use Inviqa\Worldpay\Api\XmlNodeDefaults;

class Cancel extends XmlNodeDefaults implements OrderModification
{
    public function __construct() {}

    public function xmlChildren()
    {
        return [];
    }
}
