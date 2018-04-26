<?php

namespace Inviqa\Worldpay\Api;

use Sabre\Xml\Writer;

class XmlNodeConverter
{
    private $writer;

    public function __construct(Writer $writer)
    {
        $this->writer = $writer;
    }

    public function toXml(XmlConvertibleNode $node)
    {
        $this->writer->openMemory();
        $this->writer->setIndent(true);
        $this->writer->startDocument("1.0","UTF-8");
        $this->writer->write('<!DOCTYPE paymentService PUBLIC "-//Worldpay//DTD Worldpay PaymentService v1//EN" "http://dtd.worldpay.com/paymentService_v1.dtd">');

        $this->convertNode($node);

        return $this->writer->outputMemory();
    }

    private function convertNode(XmlConvertibleNode $node)
    {
        $children = array_filter($node->xmlChildren());

        if ($node->xmlType() === XmlConvertibleNode::NODE_TYPE) {
            $this->writer->startElement($node->xmlLabel());

            if (!empty($children)) {
                foreach ($children as $child) {
                    $this->convertNode($child);
                }
            } else {
                $this->writer->write((string)$node);
            }

            $this->writer->endElement();
        } elseif ($node->xmlType() === XmlConvertibleNode::ATTR_TYPE) {
            $this->writer->startAttribute($node->xmlLabel());
            $this->writer->write((string)$node);
            $this->writer->endAttribute();
        } elseif ($node->xmlType() === XmlConvertibleNode::VALUE_TYPE) {
            $this->writer->write((string)$node);
        }
    }
}
