<?php

namespace Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation;

use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Amount;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Description;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Dynamic3DS;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\HcgAdditionalData;
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
    private $hcgAdditionalData;

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

    public function withDynamic3DS(Dynamic3DS $dynamic3DS): self
    {
        $instance = clone $this;
        $instance->dynamic3DS = $dynamic3DS;

        return $instance;
    }

    public function withHighRisk(HcgAdditionalData $hcgAdditionalData): self
    {
        $instance = clone $this;
        $instance->hcgAdditionalData = $hcgAdditionalData;

        return $instance;
    }

    public function xmlChildren()
    {
        return [
            $this->orderCode,
            $this->description,
            $this->amount,
            $this->paymentDetails,
            $this->shopper,
            $this->dynamic3DS,
            $this->hcgAdditionalData,
        ];
    }

    public function xmlLabel()
    {
        return 'order';
    }
}
