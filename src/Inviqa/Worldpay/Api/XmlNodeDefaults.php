<?php

namespace Inviqa\Worldpay\Api;

use Inviqa\Worldpay\Api\Exception\InvalidRequestParameterException;

class XmlNodeDefaults implements XmlConvertibleNode
{
    protected $string;

    public function __construct(string $string = null) {
        if (empty($string)) {
            throw new InvalidRequestParameterException(sprintf(
                "Invalid %s request parameter. Expected a non-empty value. Got '%s'.",
                $this->xmlLabel(),
                $string
            ));
        }

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
