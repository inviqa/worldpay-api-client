<?php

namespace spec\Inviqa\Worldpay\Api\Response;

use Inviqa\Worldpay\Api\Client\HttpResponse;
use Inviqa\Worldpay\Api\Response\PaymentService\Reply\OrderStatus\OrderCode;
use PhpSpec\ObjectBehavior;
use Services\OrderFactory;

class AuthorisedResponseSpec extends ObjectBehavior
{
    const XML = "<reply><orderStatus orderCode=\"order-ecomm-test-123\"><lastEvent>AUTHORISED</lastEvent></orderStatus></reply>";
    const REQUEST_XML = "<foo><bar></bar></foo>";
    const XML_3DS = "<reply><orderStatus orderCode=\"order-ecomm-test-123\"><request3DSecure><paRequest>abc</paRequest><issuerURL><![CDATA[localhost]]></issuerURL></request3DSecure></orderStatus></reply>";
    const ERROR_XML = "<reply><error code=\"" . self::ERROR_CODE . "\"><![CDATA[" . self::ERROR_MSG . "]]></error></reply>";
    const ERROR_MSG = "An internal CSE service error has occurred.";
    const ERROR_CODE = "5";
    const OLD_PAYMENT_AUTHORISED_RESPONSE = '
<paymentService version="1.4" merchantCode="ExampleCode1">
  <reply>
    <orderStatus orderCode="ExampleOrder1">
      <payment>
        <paymentMethod>VISA-SSL</paymentMethod>
        <amount value="5000" currencyCode="GBP" exponent="2" debitCreditIndicator="credit"/>
        <lastEvent>AUTHORISED</lastEvent>
        <AuthorisationId id="666"/> 
        <cardHolderName>
            <![CDATA[liviu]]>
        </cardHolderName>
        <balance accountType="IN_PROCESS_AUTHORISED">
          <amount value="5000" currencyCode="GBP" exponent="2" debitCreditIndicator="credit"/>
        </balance>
        <cardNumber>4444********1111</cardNumber>
        <riskScore value="0"/>
      </payment>
    </orderStatus>
  </reply>
</paymentService>
';

    function it_returns_the_response_details_when_the_last_event_is_authorised()
    {
        $this->beConstructedWith(
            HttpResponse::fromContentAndCookie(self::XML, "foo:bar"),
            self::REQUEST_XML
        );

        $this->isSuccessful()->shouldReturn(true);
        $this->rawXml()->shouldReturn(self::XML);
        $this->orderCode()->shouldBeLike(new OrderCode("order-ecomm-test-123"));
        $this->machineCookie()->shouldReturn("foo:bar");
    }

    function it_returns_the_error_code_and_message()
    {
        $this->beConstructedWith(
            HttpResponse::fromContentAndCookie(self::ERROR_XML),
            self::REQUEST_XML
        );

        $this->isError()->shouldReturn(true);
        $this->errorCode()->shouldReturn(self::ERROR_CODE);
        $this->errorMessage()->shouldReturn(self::ERROR_MSG);
        $this->paRequestValue()->shouldReturn("");
    }

    function it_returns_3dsecure_data_when_the_response_contains_the_request3DSecure_node()
    {
        $this->beConstructedWith(
            HttpResponse::fromContentAndCookie(self::XML_3DS),
            self::REQUEST_XML
        );

        $this->is3DSecure()->shouldReturn(true);
        $this->isSuccessful()->shouldReturn(false);
        $this->paRequestValue()->shouldReturn("abc");
        $this->issuerURL()->shouldReturn("localhost");
    }

    function it_returns_card_details_excluding_expiry_date()
    {
        $this->beConstructedWith(
            HttpResponse::fromContentAndCookie(self::OLD_PAYMENT_AUTHORISED_RESPONSE),
            self::REQUEST_XML
        );

        $this->cardDetails()->shouldReturn([
            'creditCard' => [
                'type' => 'VISA-SSL',
                'cardholderName' => 'liviu',
                'number' => '4444********1111',
            ]
        ]);
    }

    function it_returns_card_details_including_expiry_date()
    {
        $this->beConstructedWith(
            HttpResponse::fromContentAndCookie(OrderFactory::cseResponseXmlForOrderCode('1234')),
            self::REQUEST_XML
        );

        $this->cardDetails()->shouldReturn([
            'creditCard' => [
                'type' => 'VISA-SSL',
                'cardholderName' => 'liviu',
                'number' => '4111********1111',
                'expiryMonth' => '11',
                'expiryYear' => '2020',
            ]
        ]);
    }
}
