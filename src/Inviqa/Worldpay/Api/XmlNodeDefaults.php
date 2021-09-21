<?php

namespace Inviqa\Worldpay\Api;

use Inviqa\Worldpay\Api\Exception\InvalidRequestParameterException;

class XmlNodeDefaults implements XmlConvertibleNode
{
    protected $string;

    public function __construct(string $string = null) {
        if ('' == $string) {
            throw new InvalidRequestParameterException(sprintf(
                "We are missing billing %s request parameter. Please check your details and submit again.",
                $this->xmlLabel()
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
