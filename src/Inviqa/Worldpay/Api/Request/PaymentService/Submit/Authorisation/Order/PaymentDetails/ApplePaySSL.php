<?php

namespace Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails;

use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\ApplePaySSL\Data;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\ApplePaySSL\Header;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\ApplePaySSL\Signature;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\ApplePaySSL\Version;
use Inviqa\Worldpay\Api\XmlNodeDefaults;

class ApplePaySSL extends XmlNodeDefaults
{
    private $header;
    private $signature;
    private $version;
    private $data;

    public function __construct(
        Header $header,
        Signature $signature,
        Version $version,
        Data $data
    ) {
        $this->header = $header;
        $this->signature = $signature;
        $this->version = $version;
        $this->data = $data;
    }

    public function xmlLabel()
    {
        return "APPLEPAY-SSL";
    }

    public function xmlChildren()
    {
        return [
            $this->header,
            $this->signature,
            $this->version,
            $this->data
        ];
    }
}
