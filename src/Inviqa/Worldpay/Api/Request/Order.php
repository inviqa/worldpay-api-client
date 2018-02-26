<?php

namespace Inviqa\Worldpay\Api\Request;

use Inviqa\Worldpay\Api\Request\Order\Amount;
use Inviqa\Worldpay\Api\Request\Order\Description;
use Inviqa\Worldpay\Api\Request\Order\OrderCode;
use Inviqa\Worldpay\Api\Request\Order\PaymentDetails;
use Inviqa\Worldpay\Api\Request\Order\Shopper;
use Inviqa\Worldpay\Api\XmlConvertibleNode;
use Inviqa\Worldpay\Api\XmlNodeDefaults;

class Order extends XmlNodeDefaults implements XmlConvertibleNode
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
