<?php
/**
 * Created by PhpStorm.
 * User: liviu
 * Date: 2/23/18
 * Time: 3:11 PM
 */

namespace Inviqa\Worldpay\Api;

interface XmlConvertibleNode
{
    const NODE_TYPE = "node";
    const ATTR_TYPE = "attribute";

    public function xmlLabel();
    public function xmlChildren();
    public function xmlType();
}
