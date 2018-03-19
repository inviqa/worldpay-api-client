<?php

namespace Inviqa\Worldpay\Api\Response;

use Inviqa\Worldpay\Api\Client\HttpResponse;
use Inviqa\Worldpay\Api\Response\PaymentService\Reply\OrderStatus\OrderCode;

class CaptureResponse extends ModifiedResponse
{
    public function orderCode()
    {
        return new OrderCode($this->nodeAttributeValue("captureReceived", "orderCode"));
    }
}
