<?php

namespace Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order;

use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Param\Param;
use Inviqa\Worldpay\Api\XmlConvertibleNode;
use Inviqa\Worldpay\Api\XmlNodeDefaults;

class HcgAdditionalData extends XmlNodeDefaults implements XmlConvertibleNode
{
    private $rgProfileID;
    private $shippingMethod;
    private $productRisk;
    private $productType;
    private $checkoutMethod;
    private $orderSource;
    private $ageOfAccountDays;
    private $timeSinceLastOrder;
    private $numberOfPurchases;
    private $numberOfStyles;
    private $numberOfSkus;
    private $numberOfUnits;
    private $numberOfHighRiskUnits;

    public function __construct(
        Param $rgProfileID,
        Param $shippingMethod,
        Param $productRisk,
        Param $productType,
        Param $checkoutMethod,
        Param $orderSource,
        Param $ageOfAccountDays,
        Param $timeSinceLastOrder,
        Param $numberOfPurchases,
        Param $numberOfStyles,
        Param $numberOfSkus,
        Param $numberOfUnits,
        Param $numberOfHighRiskUnits
    ) {
        $this->rgProfileID = $rgProfileID;
        $this->shippingMethod     = $shippingMethod;
        $this->productRisk     = $productRisk;
        $this->productType     = $productType;
        $this->checkoutMethod     = $checkoutMethod;
        $this->orderSource     = $orderSource;
        $this->ageOfAccountDays     = $ageOfAccountDays;
        $this->timeSinceLastOrder     = $timeSinceLastOrder;
        $this->numberOfPurchases     = $numberOfPurchases;
        $this->numberOfStyles     = $numberOfStyles;
        $this->numberOfSkus     = $numberOfSkus;
        $this->numberOfUnits     = $numberOfUnits;
        $this->numberOfHighRiskUnits     = $numberOfHighRiskUnits;
    }

    public function xmlChildren()
    {
        return [
            $this->rgProfileID,
            $this->shippingMethod,
            $this->productRisk,
            $this->productType,
            $this->checkoutMethod,
            $this->orderSource,
            $this->ageOfAccountDays,
            $this->timeSinceLastOrder,
            $this->numberOfPurchases,
            $this->numberOfStyles,
            $this->numberOfSkus,
            $this->numberOfUnits,
            $this->numberOfHighRiskUnits,
        ];
    }
}
