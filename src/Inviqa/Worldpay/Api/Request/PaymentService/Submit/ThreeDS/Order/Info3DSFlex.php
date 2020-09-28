<?php

namespace Inviqa\Worldpay\Api\Request\PaymentService\Submit\ThreeDS\Order;

use Inviqa\Worldpay\Api\Request\PaymentService\Submit\ThreeDS\Order\Info3DSFlex\CompletedAuthentication;
use Inviqa\Worldpay\Api\XmlNodeDefaults;

class Info3DSFlex extends XmlNodeDefaults
{
    /**
     * @var CompletedAuthentication
     */
    private $completedAuthentication;

    public function __construct(CompletedAuthentication $completedAuthentication) {
        $this->completedAuthentication = $completedAuthentication;
    }

    public function xmlChildren()
    {
        return [
            $this->completedAuthentication
        ];
    }

    public function xmlLabel()
    {
        return 'Info3DSecure';
    }
}
