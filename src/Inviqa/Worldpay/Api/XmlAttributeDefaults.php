<?php

namespace Inviqa\Worldpay\Api;

class XmlAttributeDefaults extends XmlNodeDefaults
{
    public function xmlType()
    {
        return XmlConvertibleNode::ATTR_TYPE;
    }
}
