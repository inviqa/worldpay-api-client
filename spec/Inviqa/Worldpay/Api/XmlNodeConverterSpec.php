<?php

namespace spec\Inviqa\Worldpay\Api;

use Inviqa\Worldpay\Api\Request\Order\PaymentDetails\Session;
use Inviqa\Worldpay\Api\Request\Order\PaymentDetails\Session\Id;
use Inviqa\Worldpay\Api\Request\Order\PaymentDetails\Session\ShopperIPAddress;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Sabre\Xml\Writer;
use Services\OrderFactory;

class XmlNodeConverterSpec extends ObjectBehavior
{
    function let(Writer $writer)
    {
        $this->beConstructedWith($writer);
    }

    function it_converts_an_order_to_xml_format(Writer $writer)
    {
        $xml = OrderFactory::simpleCseOrderXml();

        $writer->openMemory()->shouldBeCalled();
        $writer->startElement('order')->shouldBeCalled();
        $writer->startAttribute('orderCode')->shouldBeCalled();
        $writer->startElement('description')->shouldBeCalled();
        $writer->startElement('amount')->shouldBeCalled();
        $writer->startAttribute('currencyCode')->shouldBeCalled();
        $writer->startAttribute('exponent')->shouldBeCalled();
        $writer->startAttribute('value')->shouldBeCalled();
        $writer->startElement('paymentDetails')->shouldBeCalled();
        $writer->startElement('CSE-DATA')->shouldBeCalled();
        $writer->startElement('encryptedData')->shouldBeCalled();
        $writer->startElement('cardAddress')->shouldBeCalled();
        $writer->startElement('address')->shouldBeCalled();
        $writer->startElement('address1')->shouldBeCalled();
        $writer->startElement('address2')->shouldBeCalled();
        $writer->startElement('address3')->shouldBeCalled();
        $writer->startElement('postalCode')->shouldBeCalled();
        $writer->startElement('city')->shouldBeCalled();
        $writer->startElement('state')->shouldBeCalled();
        $writer->startElement('countryCode')->shouldBeCalled();
        $writer->startElement('session')->shouldBeCalled();
        $writer->startAttribute('shopperIPAddress')->shouldBeCalled();
        $writer->startAttribute('id')->shouldBeCalled();
        $writer->startElement('shopper')->shouldBeCalled();
        $writer->startElement('shopperEmailAddress')->shouldBeCalled();
        $writer->startElement('browser')->shouldBeCalled();
        $writer->startElement('acceptHeader')->shouldBeCalled();
        $writer->startElement('userAgentHeader')->shouldBeCalled();


        $writer->write(Argument::any())->shouldBeCalled();
        $writer->endElement()->shouldBeCalled();
        $writer->endAttribute(Argument::any())->shouldBeCalled();
        $writer->outputMemory()->willReturn($xml)->shouldBeCalled();

        $this->toXml(OrderFactory::simpleCseOrder())->shouldReturn($xml);
    }

}
