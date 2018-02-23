<?php

namespace Inviqa\Worldpay\Api\Request;

use Inviqa\Worldpay\Api\OrderCode;
use Inviqa\Worldpay\Api\Request\Order\Amount;
use Inviqa\Worldpay\Api\Request\Order\Description;
use Inviqa\Worldpay\Api\Request\Order\PaymentDetails;
use Inviqa\Worldpay\Api\Request\Order\Shopper;

class Order
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
}
