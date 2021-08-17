<?php

namespace Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\FraudSightData;

use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\FraudSightData\CustomField\CustomField;
use Inviqa\Worldpay\Api\XmlNodeDefaults;

class CustomNumericFields extends XmlNodeDefaults
{
    /**
     * @var bool
     */
    private $renderEmptyFields;
    private $customNumericField1;
    private $customNumericField2;
    private $customNumericField3;
    private $customNumericField4;
    private $customNumericField5;
    private $customNumericField6;
    private $customNumericField7;
    private $customNumericField8;
    private $customNumericField9;
    private $customNumericField10;

    public function __construct(
        $renderEmptyFields,
        CustomField $customNumericField1,
        CustomField $customNumericField2,
        CustomField $customNumericField3,
        CustomField $customNumericField4,
        CustomField $customNumericField5,
        CustomField $customNumericField6,
        CustomField $customNumericField7,
        CustomField $customNumericField8,
        CustomField $customNumericField9,
        CustomField $customNumericField10
    ) {
        $this->renderEmptyFields = $renderEmptyFields;
        $this->customNumericField1 = $customNumericField1;
        $this->customNumericField2 = $customNumericField2;
        $this->customNumericField3 = $customNumericField3;
        $this->customNumericField4 = $customNumericField4;
        $this->customNumericField5 = $customNumericField5;
        $this->customNumericField6 = $customNumericField6;
        $this->customNumericField7 = $customNumericField7;
        $this->customNumericField8 = $customNumericField8;
        $this->customNumericField9 = $customNumericField9;
        $this->customNumericField10 = $customNumericField10;
    }

    public function xmlChildren()
    {
        return array_filter([
            $this->customNumericField1,
            $this->customNumericField2,
            $this->customNumericField3,
            $this->customNumericField4,
            $this->customNumericField5,
            $this->customNumericField6,
            $this->customNumericField7,
            $this->customNumericField8,
            $this->customNumericField9,
            $this->customNumericField10
        ], function(CustomField $field) {
            return $this->renderEmptyFields || !empty($field->string);
        });
    }
}
