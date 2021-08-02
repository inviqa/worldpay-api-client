<?php

namespace Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\FraudSightData\ShopperFields\BirthDate;

use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\FraudSightData\ShopperFields\BirthDate\Date\DayOfMonth;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\FraudSightData\ShopperFields\BirthDate\Date\Month;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\FraudSightData\ShopperFields\BirthDate\Date\Year;
use Inviqa\Worldpay\Api\XmlNodeDefaults;

class Date extends XmlNodeDefaults
{
    private $dayOfMonth;
    private $month;
    private $year;

    public function __construct(
        DayOfMonth $dayOfMonth,
        Month $month,
        Year $year
    ) {
        $this->dayOfMonth = $dayOfMonth;
        $this->month = $month;
        $this->year = $year;
    }

    public function xmlChildren()
    {
        return [
            $this->dayOfMonth,
            $this->month,
            $this->year
        ];
    }
}
