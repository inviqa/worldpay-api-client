<?php

namespace Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order;

use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Param\Param;
use Inviqa\Worldpay\Api\XmlConvertibleNode;
use Inviqa\Worldpay\Api\XmlNodeDefaults;

class HcgAdditionalData extends XmlNodeDefaults implements XmlConvertibleNode
{
    private $rgProfileID;
    private $xField1;
    private $xField2;
    private $xField3;
    private $xField4;
    private $xField5;
    private $nField1;
    private $nField2;
    private $nField3;
    private $nField4;
    private $nField5;
    private $nField6;
    private $nField7;

    public function __construct(
        Param $rgProfileID,
        Param $xField1,
        Param $xField2,
        Param $xField3,
        Param $xField4,
        Param $xField5,
        Param $nField1,
        Param $nField2,
        Param $nField3,
        Param $nField4,
        Param $nField5,
        Param $nField6,
        Param $nField7
    ) {
        $this->rgProfileID = $rgProfileID;
        $this->xField1     = $xField1;
        $this->xField2     = $xField2;
        $this->xField3     = $xField3;
        $this->xField4     = $xField4;
        $this->xField5     = $xField5;
        $this->nField1     = $nField1;
        $this->nField2     = $nField2;
        $this->nField3     = $nField3;
        $this->nField4     = $nField4;
        $this->nField5     = $nField5;
        $this->nField6     = $nField6;
        $this->nField7     = $nField7;
    }

    public function xmlChildren()
    {
        return [
            $this->rgProfileID,
            $this->xField1,
            $this->xField2,
            $this->xField3,
            $this->xField4,
            $this->xField5,
            $this->nField1,
            $this->nField2,
            $this->nField3,
            $this->nField4,
            $this->nField5,
            $this->nField6,
            $this->nField7,
        ];
    }
}
