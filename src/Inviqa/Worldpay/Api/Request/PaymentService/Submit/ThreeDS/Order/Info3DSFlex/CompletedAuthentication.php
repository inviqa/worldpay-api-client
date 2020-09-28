<?php

namespace Inviqa\Worldpay\Api\Request\PaymentService\Submit\ThreeDS\Order\Info3DSFlex;

use Inviqa\Worldpay\Api\XmlNodeEmpty;

class CompletedAuthentication extends XmlNodeEmpty
{
    public function xmlLabel()
    {
        return 'CompletedAuthentication';
    }
}
