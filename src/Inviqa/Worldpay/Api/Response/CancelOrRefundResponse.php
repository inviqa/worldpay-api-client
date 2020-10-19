<?php

namespace Inviqa\Worldpay\Api\Response;

use Inviqa\Worldpay\Api\Response\PaymentService\Reply\OrderStatus\OrderCode;

class CancelOrRefundResponse extends ModifiedResponse
{
    public function orderCode()
    {
        return new OrderCode($this->nodeAttributeValue("voidReceived", "orderCode"));
    }
}
