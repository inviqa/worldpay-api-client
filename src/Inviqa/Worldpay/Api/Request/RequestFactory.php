<?php

namespace Inviqa\Worldpay\Api\Request;

interface RequestFactory
{
    public function buildFromRequestParameters(array $parameters): PaymentService;
}
