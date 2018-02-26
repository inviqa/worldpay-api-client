<?php

namespace Inviqa\Worldpay\Api\Response;

use Inviqa\Worldpay\Api\Response\PaymentService\Reply\OrderStatus\OrderCode;

class AuthorizedResponse implements Response
{
    /**
     * @return OrderCode
     */
    public function orderCode()
    {
        return new OrderCode("3279686");
    }
}
