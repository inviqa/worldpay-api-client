<?php

namespace Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Param;

use Inviqa\Worldpay\Api\XmlNodeDefaults;

class Param extends XmlNodeDefaults
{
    private $name;
    private $value;

    public function __construct(
        Name $name,
        Value $value
    )
    {
        $this->name = $name;
        $this->value = $value;
    }

    public function xmlChildren()
    {
        return [
            $this->name,
            $this->value,
        ];
    }
}
