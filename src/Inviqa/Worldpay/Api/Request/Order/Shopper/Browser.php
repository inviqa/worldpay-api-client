<?php

namespace Inviqa\Worldpay\Api\Request\Order\Shopper;

use Inviqa\Worldpay\Api\Request\Order\Shopper\Browser\AcceptHeader;
use Inviqa\Worldpay\Api\Request\Order\Shopper\Browser\UserAgentHeader;
use Inviqa\Worldpay\Api\XmlNodeDefaults;

class Browser extends XmlNodeDefaults
{
    private $acceptHeader;
    private $userAgentHeader;

    public function __construct(
        AcceptHeader $acceptHeader,
        UserAgentHeader $userAgentHeader
    )
    {
        $this->acceptHeader = $acceptHeader;
        $this->userAgentHeader = $userAgentHeader;
    }

    public function xmlChildren()
    {
        return [
            $this->acceptHeader,
            $this->userAgentHeader,
        ];
    }
}
