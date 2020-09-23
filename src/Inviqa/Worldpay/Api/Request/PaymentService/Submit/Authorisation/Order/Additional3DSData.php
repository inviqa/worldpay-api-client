<?php

namespace Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order;

use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Additional3DSData\ChallengePreference;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Additional3DSData\ChallengeWindowSize;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Additional3DSData\DfReferenceId;
use Inviqa\Worldpay\Api\XmlNodeDefaults;

class Additional3DSData extends XmlNodeDefaults
{
    private $dfReferenceId;

    public function __construct(
        DfReferenceId $dfReferenceId
    ) {
        $this->dfReferenceId = $dfReferenceId;
    }

    public function xmlChildren()
    {
        return [
            $this->dfReferenceId,
        ];
    }
}