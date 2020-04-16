<?php

namespace spec\Inviqa\Worldpay\Api;

use PhpSpec\ObjectBehavior;
use Sabre\Xml\Writer;
use Services\OrderFactory;

class XmlNodeConverterSpec extends ObjectBehavior
{
    function let(Writer $writer)
    {
        $this->beConstructedWith($writer);
    }

    function it_converts_a_payment_service_order_request_to_xml_format(Writer $writer)
    {
        $xml = OrderFactory::simpleCsePaymentServiceRequestXml();

        $writer->openMemory()->shouldBeCalled();
        $writer->setIndent(true)->shouldBeCalled();
        $writer->startDocument("1.0","UTF-8")->shouldBeCalled();
        $writer->write('<!DOCTYPE paymentService PUBLIC "-//Worldpay//DTD Worldpay PaymentService v1//EN" "http://dtd.worldpay.com/paymentService_v1.dtd">')
            ->shouldBeCalled();
        $writer->startElement('paymentService')->shouldBeCalled();
        $writer->startAttribute('version')->shouldBeCalled();
        $writer->startAttribute('merchantCode')->shouldBeCalled();
        $writer->startElement('submit')->shouldBeCalled();
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
        $writer->startElement('firstName')->shouldBeCalled();
        $writer->startElement('lastName')->shouldBeCalled();
        $writer->startElement('cardAddress')->shouldBeCalled();
        $writer->startElement('address')->shouldBeCalled();
        $writer->startElement('address1')->shouldBeCalled();
        $writer->startElement('address2')->shouldBeCalled();
        $writer->startElement('address3')->shouldBeCalled();
        $writer->startElement('postalCode')->shouldBeCalled();
        $writer->startElement('city')->shouldBeCalled();
        $writer->startElement('state')->shouldBeCalled();
        $writer->startElement('countryCode')->shouldBeCalled();
        $writer->startElement('telephoneNumber')->shouldBeCalled();
        $writer->startElement('session')->shouldBeCalled();
        $writer->startAttribute('shopperIPAddress')->shouldBeCalled();
        $writer->startAttribute('id')->shouldBeCalled();
        $writer->startElement('shopper')->shouldBeCalled();
        $writer->startElement('shopperEmailAddress')->shouldBeCalled();
        $writer->startElement('browser')->shouldBeCalled();
        $writer->startElement('acceptHeader')->shouldBeCalled();
        $writer->startElement('userAgentHeader')->shouldBeCalled();
        $writer->startElement('shippingAddress')->shouldBeCalled();
        $writer->startElement('dynamic3DS')->shouldBeCalled();
        $writer->startAttribute('overrideAdvice')->shouldBeCalled();
        $writer->startElement('hcgAdditionalData')->shouldBeCalled();
        $writer->startElement('param')->shouldBeCalled();
        $writer->startAttribute('name')->shouldBeCalled();

        $writer->write("1.4")->shouldBeCalled();
        $writer->write("SESSIONECOM")->shouldBeCalled();
        $writer->write("order-ecomm-test-03")->shouldBeCalled();
        $writer->write("test ecomm order")->shouldBeCalled();
        $writer->write("GBP")->shouldBeCalled();
        $writer->write("2")->shouldBeCalled();
        $writer->write("1500")->shouldBeCalled();
        $writer->write("eyJhbGciOiJSU0ExXzUiLCJlbmMiOiJBMjU2R0NNIiwia2lkIjoiMSIsImNvbS53b3JsZHBheS5hcGlWZXJzaW9uIjoiMS4wIiwiY29tLndvcmxkcGF5LmxpYlZlcnNpb24iOiIxLjAuMSIsImNvbS53b3JsZHBheS5jaGFubmVsIjoiamF2YXNjcmlwdCJ9.dKfhn7pnZKfMA4Sy8ODL30o0IAsJgGkYqgaObvWpahlhW2owo-Y3xwyeXc82_kd4UJ-UN4VNxJPuENYCNEa0iq4WE_vSMiBV9d_vZK91e-lJvpHqtucc9HI0T7fh5t7-QU0qhkLj_06W57hE3-HkKhI8-ZfOLbxN0XsQk7ZFpCrK4MT-IPJTk4Twrk2b9eAbnRuTMT-mFNh8lFeZZLp42FaTuLuchPGh1SqE3ln_1oUQppnm8mYkKWNgZlY3pjFpmJFlyrhK-7y-OxVz_FtKpd79fyxtAY1nLB_WO_gmAwFVGOnKwvdsTk_FDVPZ8lRe3LRLJ7pc9gzmw8oyH1gSRQ.dTOinx-7v0pFKvhA.8ZLx2l-HUrG6rFKOqELSyCNXw69CAEvY2F1xRoSiKtiHrxvmdBs5Wz_VPwjnYEEyhf-1Brioyq6A9O0NZZgmAMwk7GBbSKmxzoszbZ-ItSRumG714iDuQ0mqAYPPkq3bxY4mNavPreBXp7eXNg.IVkvoJ3Z2iH-6XgUMDR2LQ")
            ->shouldBeCalled();
        $writer->write("Tim")->shouldBeCalled();
        $writer->write("Webster")->shouldBeCalled();
        $writer->write("47A")->shouldBeCalled();
        $writer->write("7")->shouldBeCalled();
        $writer->write("Queensbridge Road")->shouldBeCalled();
        $writer->write("Crisswell Close")->shouldBeCalled();
        $writer->write("Suburbia")->shouldBeCalled();
        $writer->write("Crownhill")->shouldBeCalled();
        $writer->write("CB94BQ")->shouldBeCalled();
        $writer->write("PA16 0XA")->shouldBeCalled();
        $writer->write("Cambridge")->shouldBeCalled();
        $writer->write("Milton Keynes")->shouldBeCalled();
        $writer->write("Cambridgeshire")->shouldBeCalled();
        $writer->write("Bucks")->shouldBeCalled();
        $writer->write("GB")->shouldBeCalled();
        $writer->write("07426000000")->shouldBeCalled();
        $writer->write("07426111111")->shouldBeCalled();
        $writer->write("123.123.123.123")->shouldBeCalled();
        $writer->write("0215ui8ib1")->shouldBeCalled();
        $writer->write("lpanainte+test@inviqa.com")->shouldBeCalled();
        $writer->write("text/html")->shouldBeCalled();
        $writer->write("Mozilla/5.0")->shouldBeCalled();
        $writer->write("no3DS")->shouldBeCalled();
        $writer->write("RGProfileID")->shouldBeCalled();
        $writer->write("xField1")->shouldBeCalled();
        $writer->write("xField2")->shouldBeCalled();
        $writer->write("xField3")->shouldBeCalled();
        $writer->write("xField4")->shouldBeCalled();
        $writer->write("xField5")->shouldBeCalled();
        $writer->write("xField6")->shouldBeCalled();
        $writer->write("nField1")->shouldBeCalled();
        $writer->write("nField2")->shouldBeCalled();
        $writer->write("nField3")->shouldBeCalled();
        $writer->write("nField4")->shouldBeCalled();
        $writer->write("nField5")->shouldBeCalled();
        $writer->write("nField6")->shouldBeCalled();
        $writer->write("nField7")->shouldBeCalled();
        $writer->write(201477)->shouldBeCalled();
        $writer->write("UK Next Day")->shouldBeCalled();
        $writer->write("Registered")->shouldBeCalled();
        $writer->write(4.5678)->shouldBeCalled();
        $writer->write(3.4567)->shouldBeCalled();
        $writer->write(5)->shouldBeCalled();
        $writer->write("High")->shouldBeCalled();
        $writer->write("")->shouldBeCalled();
        $writer->write(2)->shouldBeCalled();
        $writer->write(3)->shouldBeCalled();
        $writer->write(3)->shouldBeCalled();
        $writer->write(1)->shouldBeCalled();
        $writer->endElement()->shouldBeCalled();
        $writer->endAttribute()->shouldBeCalled();
        $writer->outputMemory()->willReturn($xml)->shouldBeCalled();

        $this->toXml(OrderFactory::simpleCsePaymentService())->shouldReturn($xml);
    }
}
