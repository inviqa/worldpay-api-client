<?php

namespace Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order;

use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Param\Param;
use Inviqa\Worldpay\Api\XmlConvertibleNode;
use Inviqa\Worldpay\Api\XmlNodeDefaults;

class HcgAdditionalData extends XmlNodeDefaults implements XmlConvertibleNode
{
    private $param;

    public function __construct(
        Param $param
    )
    {
        $this->param = $param;
    }

    public function xmlChildren()
    {
        return [
            $this->param,
        ];
    }
}
