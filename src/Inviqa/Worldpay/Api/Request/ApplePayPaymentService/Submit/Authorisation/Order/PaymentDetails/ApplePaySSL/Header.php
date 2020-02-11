<?php

namespace Inviqa\Worldpay\Api\Request\ApplePayPaymentService\Submit\Authorisation\Order\PaymentDetails\ApplePaySSL;

use Inviqa\Worldpay\Api\Request\ApplePayPaymentService\Submit\Authorisation\Order\PaymentDetails\ApplePaySSL\Header\EphemeralPublicKey;
use Inviqa\Worldpay\Api\Request\ApplePayPaymentService\Submit\Authorisation\Order\PaymentDetails\ApplePaySSL\Header\PublicKeyHash;
use Inviqa\Worldpay\Api\Request\ApplePayPaymentService\Submit\Authorisation\Order\PaymentDetails\ApplePaySSL\Header\TransactionId;
use Inviqa\Worldpay\Api\XmlNodeDefaults;

class Header extends XmlNodeDefaults
{
    private $ephemeralPublicKey;
    private $publicKeyHash;
    private $transactionId;

    public function __construct(
        EphemeralPublicKey $ephemeralPublicKey,
        PublicKeyHash $publicKeyHash,
        TransactionId $transactionId
    ) {
        $this->ephemeralPublicKey = $ephemeralPublicKey;
        $this->publicKeyHash = $publicKeyHash;
        $this->transactionId = $transactionId;
    }

    public function xmlChildren()
    {
        return [
            $this->ephemeralPublicKey,
            $this->publicKeyHash,
            $this->transactionId
        ];
    }
}
