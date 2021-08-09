<?php

namespace Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\FraudSightData\CustomField;

use Inviqa\Worldpay\Api\XmlNodeDefaults;

class CustomField extends XmlNodeDefaults
{
    private $label;
    private $value;

    public function __construct(
        string $label,
        Value $value
    )
    {
        $this->label = $label;
        $this->value = $value;
    }

    public function xmlChildren()
    {
        return [
            $this->value,
        ];
    }

    public function xmlLabel()
    {
        return $this->label;
    }
}
