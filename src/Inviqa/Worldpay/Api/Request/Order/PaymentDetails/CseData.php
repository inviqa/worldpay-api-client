<?php

namespace Inviqa\Worldpay\Api\Request\Order\PaymentDetails;

use Inviqa\Worldpay\Api\Request\Order\PaymentDetails\CseData\CardAddress;
use Inviqa\Worldpay\Api\Request\Order\PaymentDetails\CseData\EncryptedData;

class CseData
{
    private $encryptedData;
    private $cardAddress;

    public function __construct(
        EncryptedData $encryptedData,
        CardAddress $cardAddress
    ) {
        $this->encryptedData = $encryptedData;
        $this->cardAddress = $cardAddress;
    }
}
