<?php

namespace Inviqa\Worldpay\Api;

class XmlValueDefaults extends XmlNodeDefaults
{
    public function xmlType()
    {
        return XmlConvertibleNode::VALUE_TYPE;
    }
}
