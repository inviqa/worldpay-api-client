<?php

namespace Inviqa\Worldpay;

use Inviqa\Worldpay\Api\Response\AuthorizedResponse;

class Application
{
    public function authorizePayment(array $paymentParamters)
    {
        return new AuthorizedResponse();
    }
}
