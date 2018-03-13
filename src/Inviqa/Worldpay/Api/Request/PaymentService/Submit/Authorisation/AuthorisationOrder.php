<?php

namespace Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation;

use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Amount;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Description;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Dynamic3DS;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\OrderCode;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Shopper;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Order;
use Inviqa\Worldpay\Api\XmlNodeDefaults;

class AuthorisationOrder extends XmlNodeDefaults implements Order
{
    private $orderCode;
    private $description;
    private $amount;
    private $paymentDetails;
    private $shopper;
    private $dynamic3DS;

    public function __construct(
        OrderCode $orderCode,
        Description $description,
        Amount $amount,
        PaymentDetails $paymentDetails,
        Shopper $shopper,
        Dynamic3DS $dynamic3DS = null
    ) {
        $this->orderCode = $orderCode;
        $this->description = $description;
        $this->amount = $amount;
        $this->paymentDetails = $paymentDetails;
        $this->shopper = $shopper;
        $this->dynamic3DS = $dynamic3DS;
    }

    public function xmlChildren()
    {
        $children = [
            $this->orderCode,
            $this->description,
            $this->amount,
            $this->paymentDetails,
            $this->shopper
        ];

        if ($this->dynamic3DS) {
            $children[] = $this->dynamic3DS;
        }

        return $children;
    }

    public function xmlLabel()
    {
        return 'order';
    }
}
