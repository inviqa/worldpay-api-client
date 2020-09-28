<?php

namespace Inviqa\Worldpay\Api;

use Inviqa\Worldpay\Api\Exception\InvalidRequestParameterException;

class XmlNodeEmpty implements XmlConvertibleNode
{
    protected $string;

    public function xmlChildren()
    {
        return [];
    }

    public function xmlLabel()
    {
        return lcfirst(substr(strrchr(get_class($this), '\\'), 1));
    }

    public function xmlType()
    {
        return XmlConvertibleNode::NODE_TYPE_EMPTY;
    }
}
