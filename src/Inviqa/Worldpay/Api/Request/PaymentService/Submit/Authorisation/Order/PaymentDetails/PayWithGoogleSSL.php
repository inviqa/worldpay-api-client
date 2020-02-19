<?php

namespace Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails;

use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\PayWithGoogleSSL\ProtocolVersion;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\PayWithGoogleSSL\Signature;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\PayWithGoogleSSL\SignedMessage;
use Inviqa\Worldpay\Api\XmlNodeDefaults;

class PayWithGoogleSSL extends XmlNodeDefaults
{
    private $protocolVersion;
    private $signature;
    private $signedMessage;

    public function __construct(
        ProtocolVersion $protocolVersion,
        Signature $signature,
        SignedMessage $signedMessage
    ) {
        $this->protocolVersion = $protocolVersion;
        $this->signature = $signature;
        $this->signedMessage = $signedMessage;
    }

    public function xmlLabel()
    {
        return "PAYWITHGOOGLE-SSL";
    }

    public function xmlChildren()
    {
        return [
            $this->protocolVersion,
            $this->signature,
            $this->signedMessage,
        ];
    }
}
