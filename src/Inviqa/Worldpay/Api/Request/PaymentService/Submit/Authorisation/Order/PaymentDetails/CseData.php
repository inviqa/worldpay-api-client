<?php

namespace Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails;

use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\CseData\CardAddress;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\CseData\EncryptedData;
use Inviqa\Worldpay\Api\XmlNodeDefaults;

class CseData extends XmlNodeDefaults
{
    private $encryptedData;
    private $cardAddress;

    public function __construct(
        EncryptedData $encryptedData,
        CardAddress $cardAddress
    )
    {
        $this->encryptedData = $encryptedData;
        $this->cardAddress = $cardAddress;
    }

    public function xmlLabel()
    {
        return "CSE-DATA";
    }

    public function xmlChildren()
    {
        return [
            $this->encryptedData,
            $this->cardAddress,
        ];
    }
}
