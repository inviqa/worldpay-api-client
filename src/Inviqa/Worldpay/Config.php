<?php

namespace Inviqa\Worldpay;

interface Config
{
    public function isTestMode(): bool;
    public function username(): string;
    public function password(): string;
    public function uri(): string;
}
