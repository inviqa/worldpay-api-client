<?php

namespace Inviqa\Worldpay\Api;

class XmlNodeDefaults implements XmlConvertibleNode
{
    protected $string;

    public function __construct(string $string) {
        $this->string = $string;
    }

    public function __toString()
    {
        return (string)$this->string;
    }

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
        return XmlConvertibleNode::NODE_TYPE;
    }
}
