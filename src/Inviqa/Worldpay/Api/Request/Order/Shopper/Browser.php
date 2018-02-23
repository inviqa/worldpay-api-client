<?php

namespace Inviqa\Worldpay\Api\Request\Order\Shopper;

use Inviqa\Worldpay\Api\Request\Order\Shopper\Browser\AcceptHeader;
use Inviqa\Worldpay\Api\Request\Order\Shopper\Browser\UserAgentHeader;

class Browser
{
    private $acceptHeader;
    private $userAgentHeader;

    public function __construct(
        AcceptHeader $acceptHeader,
        UserAgentHeader $userAgentHeader
    ) {
        $this->acceptHeader = $acceptHeader;
        $this->userAgentHeader = $userAgentHeader;
    }
}
