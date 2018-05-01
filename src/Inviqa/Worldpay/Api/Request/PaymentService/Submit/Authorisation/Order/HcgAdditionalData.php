<?php

namespace Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order;

use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Param\Param;
use Inviqa\Worldpay\Api\XmlConvertibleNode;
use Inviqa\Worldpay\Api\XmlNodeDefaults;

class HcgAdditionalData extends XmlNodeDefaults implements XmlConvertibleNode
{
    private $param;
    private $xfield1;
    private $xfield2;
    private $xfield3;
    private $xfield4;
    private $nfield1;
    private $nfield2;
    private $nfield3;
    private $nfield4;
    private $nfield5;
    private $nfield6;
    private $nfield7;

    public function __construct(
        Param $xfield1,
        Param $xfield2,
        Param $xfield3,
        Param $xfield4,
        Param $nfield1,
        Param $nfield2,
        Param $nfield3,
        Param $nfield4,
        Param $nfield5,
        Param $nfield6,
        Param $nfield7
    ) {

        $this->xfield1 = $xfield1;
        $this->xfield2 = $xfield2;
        $this->xfield3 = $xfield3;
        $this->xfield4 = $xfield4;
        $this->nfield1 = $nfield1;
        $this->nfield2 = $nfield2;
        $this->nfield3 = $nfield3;
        $this->nfield4 = $nfield4;
        $this->nfield5 = $nfield5;
        $this->nfield6 = $nfield6;
        $this->nfield7 = $nfield7;
    }

    public function xmlChildren()
    {
        return [
            $this->xfield1,
            $this->xfield2,
            $this->xfield3,
            $this->xfield4,
            $this->nfield1,
            $this->nfield2,
            $this->nfield3,
            $this->nfield4,
            $this->nfield5,
            $this->nfield6,
            $this->nfield7,
        ];
    }
}
