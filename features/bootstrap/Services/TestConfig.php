<?php

namespace Services;

use Inviqa\Worldpay\Config;

class TestConfig implements Config
{
    public function isTestMode(): bool
    {
        return true;
    }

    public function username(): string
    {
        return "foo";
    }

    public function password(): string
    {
        return "bar";
    }
}
