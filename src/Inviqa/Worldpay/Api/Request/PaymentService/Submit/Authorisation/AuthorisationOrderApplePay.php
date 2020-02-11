<?php

namespace Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation;

use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Amount;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Description;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\OrderCode;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetailsApplePay;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\ShopperApplePay;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Order;
use Inviqa\Worldpay\Api\XmlNodeDefaults;

class AuthorisationOrderApplePay extends XmlNodeDefaults implements Order
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
        PaymentDetailsApplePay $paymentDetails,
        ShopperApplePay $shopper
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

    public function xmlLabel()
    {
        return 'order';
    }
}
