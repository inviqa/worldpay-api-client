<?php

namespace Inviqa\Worldpay\Api\Response;

use Inviqa\Worldpay\Api\Response\PaymentService\Reply\OrderStatus\OrderCode;

class CancelResponse extends ModifiedResponse
{
    public function orderCode()
    {
        return new OrderCode($this->nodeAttributeValue("cancelReceived", "orderCode"));
    }
}
