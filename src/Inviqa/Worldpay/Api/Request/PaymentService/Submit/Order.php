<?php

namespace Inviqa\Worldpay\Api\Request\PaymentService\Submit;

use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Order\Amount;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Order\Description;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Order\OrderCode;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Order\PaymentDetails;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Order\Shopper;
use Inviqa\Worldpay\Api\XmlNodeDefaults;

class Order extends XmlNodeDefaults
{
    private $orderCode;
    private $description;
    private $amount;
    private $paymentDetails;
    private $shopper;

    public function __construct(
        OrderCode $orderCode,
        Description $description,
        Amount $amount,
        PaymentDetails $paymentDetails,
        Shopper $shopper
    ) {
        $this->orderCode = $orderCode;
        $this->description = $description;
        $this->amount = $amount;
        $this->paymentDetails = $paymentDetails;
        $this->shopper = $shopper;
    }

    public function xmlChildren()
    {
        return [
            $this->orderCode,
            $this->description,
            $this->amount,
            $this->paymentDetails,
            $this->shopper
        ];
    }
}
