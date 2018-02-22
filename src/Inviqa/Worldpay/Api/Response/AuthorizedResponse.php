<?php

namespace Inviqa\Worldpay\Api\Response;

use Inviqa\Worldpay\Api\OrderCode;

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
