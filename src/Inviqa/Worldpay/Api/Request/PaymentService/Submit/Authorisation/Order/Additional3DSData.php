<?php

namespace Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order;

use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Additional3DSData\ChallengePreference;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Additional3DSData\ChallengeWindowSize;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Additional3DSData\DfReferenceId;
use Inviqa\Worldpay\Api\XmlNodeDefaults;

class Additional3DSData extends XmlNodeDefaults
{
    private $dfReferenceId;

    private $challengeWindowSize;

    public function __construct(
        DfReferenceId $dfReferenceId,
        ChallengeWindowSize $challengeWindowSize
    ) {
        $this->dfReferenceId = $dfReferenceId;
        $this->challengeWindowSize = $challengeWindowSize;
    }

    public function xmlChildren()
    {
        return [
            $this->dfReferenceId,
            $this->challengeWindowSize,
        ];
    }
}