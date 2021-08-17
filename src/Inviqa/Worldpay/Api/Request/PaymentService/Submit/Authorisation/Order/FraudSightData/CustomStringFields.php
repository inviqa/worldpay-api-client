<?php

namespace Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\FraudSightData;

use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\FraudSightData\CustomField\CustomField;
use Inviqa\Worldpay\Api\XmlNodeDefaults;

class CustomStringFields extends XmlNodeDefaults
{
    /**
     * @var bool
     */
    private $renderEmptyFields;
    private $customStringField1;
    private $customStringField2;
    private $customStringField3;
    private $customStringField4;
    private $customStringField5;
    private $customStringField6;
    private $customStringField7;
    private $customStringField8;
    private $customStringField9;
    private $customStringField10;

    public function __construct(
        $renderEmptyFields,
        CustomField $customStringField1,
        CustomField $customStringField2,
        CustomField $customStringField3,
        CustomField $customStringField4,
        CustomField $customStringField5,
        CustomField $customStringField6,
        CustomField $customStringField7,
        CustomField $customStringField8,
        CustomField $customStringField9,
        CustomField $customStringField10
    ) {
        $this->renderEmptyFields = $renderEmptyFields;
        $this->customStringField1 = $customStringField1;
        $this->customStringField2 = $customStringField2;
        $this->customStringField3 = $customStringField3;
        $this->customStringField4 = $customStringField4;
        $this->customStringField5 = $customStringField5;
        $this->customStringField6 = $customStringField6;
        $this->customStringField7 = $customStringField7;
        $this->customStringField8 = $customStringField8;
        $this->customStringField9 = $customStringField9;
        $this->customStringField10 = $customStringField10;
    }

    public function xmlChildren()
    {
        return array_filter([
            $this->customStringField1,
            $this->customStringField2,
            $this->customStringField3,
            $this->customStringField4,
            $this->customStringField5,
            $this->customStringField6,
            $this->customStringField7,
            $this->customStringField8,
            $this->customStringField9,
            $this->customStringField10
        ], function(CustomField $field) {
            return $this->renderEmptyFields || !empty($field->getValue()->string);
        });
    }
}
