<?php

namespace Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order;

use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Dynamic3DS\OverrideAdvice;
use Inviqa\Worldpay\Api\XmlNodeDefaults;

class Dynamic3DS extends XmlNodeDefaults
{
    /**
     * @var OverrideAdvice
     */
    private $overrideAdvice;

    public function __construct(
        OverrideAdvice $overrideAdvice
    ) {
        $this->overrideAdvice = $overrideAdvice;
    }

    public function xmlChildren()
    {
        return [
            $this->overrideAdvice
        ];
    }
}
