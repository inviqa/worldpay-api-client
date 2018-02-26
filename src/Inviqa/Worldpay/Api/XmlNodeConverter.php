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

        $this->convertNode($node);

        return $this->writer->outputMemory();
    }

    public function convertNode(XmlConvertibleNode $node)
    {
        $children = $node->xmlChildren();

        if ($node->xmlType() === XmlConvertibleNode::NODE_TYPE) {
            $this->writer->startElement($node->xmlLabel());

            if (!empty($children)) {
                foreach ($children as $child) {
                    $this->convertNode($child);
                }
            }
        } else {
            $this->writer->startAttribute($node->xmlLabel());
            $this->writer->write((string)$node);
            $this->writer->endAttribute();
        }

        $this->writer->endElement();
    }
}
