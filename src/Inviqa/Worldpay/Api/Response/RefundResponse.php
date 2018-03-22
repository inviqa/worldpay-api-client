<?php

namespace Inviqa\Worldpay\Api\Response;

use Inviqa\Worldpay\Api\Response\PaymentService\Reply\OrderStatus\OrderCode;

class RefundResponse extends ModifiedResponse
{
    public function orderCode()
    {
        return new OrderCode($this->nodeAttributeValue("refundReceived", "orderCode"));
    }
}
