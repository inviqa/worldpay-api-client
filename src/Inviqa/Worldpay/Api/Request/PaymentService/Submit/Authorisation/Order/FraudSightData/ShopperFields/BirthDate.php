<?php

namespace Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\FraudSightData\ShopperFields;

use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\FraudSightData\ShopperFields\BirthDate\Date;
use Inviqa\Worldpay\Api\XmlNodeDefaults;

class BirthDate extends XmlNodeDefaults
{
    private $date;

    public function __construct(
        Date $date
    ) {
        $this->date = $date;
    }

    public function xmlChildren()
    {
        return [
            $this->date,
        ];
    }
}
