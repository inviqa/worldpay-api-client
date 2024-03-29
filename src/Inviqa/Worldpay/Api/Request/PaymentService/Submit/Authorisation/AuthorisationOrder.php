<?php

namespace Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation;

use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Additional3DSData;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Amount;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Description;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\DeviceSession;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Dynamic3DS;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\FraudSightData;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\HcgAdditionalData;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\OrderCode;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\ShippingAddress;
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
    private $shippingAddress;
    private $hcgAdditionalData;
    private $dynamic3DS;
    private $additional3DSData;
    private $deviceSession;
    private $fraudsightData;

    public function __construct(
        OrderCode $orderCode,
        Description $description,
        Amount $amount,
        PaymentDetails $paymentDetails,
        Shopper $shopper,
        HcgAdditionalData $hcgAdditionalData
    ) {
        $this->orderCode = $orderCode;
        $this->description = $description;
        $this->amount = $amount;
        $this->paymentDetails = $paymentDetails;
        $this->shopper = $shopper;
        $this->hcgAdditionalData = $hcgAdditionalData;
    }

    public function withDynamic3DS(Dynamic3DS $dynamic3DS): self
    {
        $instance = clone $this;
        $instance->dynamic3DS = $dynamic3DS;

        return $instance;
    }

    public function withShippingAddress(ShippingAddress $shippingAddress): self
    {
        $instance = clone $this;
        $instance->shippingAddress = $shippingAddress;

        return $instance;
    }

    public function with3DSFlex(Additional3DSData $additional3DSData): self
    {
        $instance = clone $this;
        $instance->additional3DSData = $additional3DSData;

        return $instance;
    }

    public function withFraudsightData(FraudSightData $fraudSightData): self
    {
        $instance = clone $this;
        $instance->fraudsightData = $fraudSightData;

        return $instance;
    }

    public function withFraudsightSession(DeviceSession $deviceSession): self
    {
        $instance = clone $this;
        $instance->deviceSession = $deviceSession;

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
            $this->shippingAddress,
            $this->hcgAdditionalData,
            $this->dynamic3DS,
            $this->additional3DSData,
            $this->fraudsightData,
            $this->deviceSession,
        ];
    }

    public function xmlLabel()
    {
        return 'order';
    }
}
