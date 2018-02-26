<?php

namespace Inviqa\Worldpay\Api\Request;

use Inviqa\Worldpay\Api\Request\PaymentService\MerchantCode;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit;
use Inviqa\Worldpay\Api\Request\PaymentService\Version;
use Inviqa\Worldpay\Api\XmlNodeDefaults;

class PaymentService extends XmlNodeDefaults
{
    private $version;
    private $merchantCode;
    private $submit;

    public function __construct(
        Version $version,
        MerchantCode $merchantCode,
        Submit $submit
    ) {
        $this->submit = $submit;
        $this->version = $version;
        $this->merchantCode = $merchantCode;
    }

    public function xmlChildren()
    {
        return [
            $this->version,
            $this->merchantCode,
            $this->submit,
        ];
    }
}
