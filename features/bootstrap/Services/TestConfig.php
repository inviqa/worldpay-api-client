<?php

namespace Services;

use Inviqa\Worldpay\Config;

class TestConfig implements Config
{
    public function isTestMode(): bool
    {
        return false;
    }

    public function username(): string
    {
        return "foo";
    }

    public function password(): string
    {
        return "bar";
    }

    public function uri(): string
    {
        return "https://secure-test.worldpay.com/jsp/merchant/xml/paymentService.jsp";
    }
}
