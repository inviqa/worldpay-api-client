<?php

namespace Services;

use Inviqa\Worldpay\Api\Request\PaymentService;
use Inviqa\Worldpay\Api\Request\PaymentService\MerchantCode;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\AuthorisationOrder;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Amount;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Amount\CurrencyCode;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Amount\Exponent;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Amount\Value;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Description;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\OrderCode;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\CseData;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\CseData\CardAddress;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\CseData\CardAddress\Address\AddressOne;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\CseData\CardAddress\Address\AddressThree;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\CseData\CardAddress\Address\AddressTwo;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\CseData\CardAddress\Address\City;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\CseData\CardAddress\Address\CountryCode;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\CseData\CardAddress\Address\PostalCode;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\CseData\CardAddress\Address\State;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\CseData\EncryptedData;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\Session;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Shopper;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Shopper\Browser;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\ThreeDS\Order\Info3DSecure;
use Inviqa\Worldpay\Api\Request\PaymentService\Version;
use Inviqa\Worldpay\Api\XmlConvertibleNode;

class OrderFactory
{
    public static function simpleCsePaymentService(): XmlConvertibleNode
    {
        $orderCode = new OrderCode("order-ecomm-test-03");
        $description = new Description("test ecomm order");
        $amount = new Amount(
            new CurrencyCode("GBP"),
            new Exponent("2"),
            new Value("1500")
        );
        $encryptedData = new EncryptedData("eyJhbGciOiJSU0ExXzUiLCJlbmMiOiJBMjU2R0NNIiwia2lkIjoiMSIsImNvbS53b3JsZHBheS5hcGlWZXJzaW9uIjoiMS4wIiwiY29tLndvcmxkcGF5LmxpYlZlcnNpb24iOiIxLjAuMSIsImNvbS53b3JsZHBheS5jaGFubmVsIjoiamF2YXNjcmlwdCJ9.dKfhn7pnZKfMA4Sy8ODL30o0IAsJgGkYqgaObvWpahlhW2owo-Y3xwyeXc82_kd4UJ-UN4VNxJPuENYCNEa0iq4WE_vSMiBV9d_vZK91e-lJvpHqtucc9HI0T7fh5t7-QU0qhkLj_06W57hE3-HkKhI8-ZfOLbxN0XsQk7ZFpCrK4MT-IPJTk4Twrk2b9eAbnRuTMT-mFNh8lFeZZLp42FaTuLuchPGh1SqE3ln_1oUQppnm8mYkKWNgZlY3pjFpmJFlyrhK-7y-OxVz_FtKpd79fyxtAY1nLB_WO_gmAwFVGOnKwvdsTk_FDVPZ8lRe3LRLJ7pc9gzmw8oyH1gSRQ.dTOinx-7v0pFKvhA.8ZLx2l-HUrG6rFKOqELSyCNXw69CAEvY2F1xRoSiKtiHrxvmdBs5Wz_VPwjnYEEyhf-1Brioyq6A9O0NZZgmAMwk7GBbSKmxzoszbZ-ItSRumG714iDuQ0mqAYPPkq3bxY4mNavPreBXp7eXNg.IVkvoJ3Z2iH-6XgUMDR2LQ");
        $cardAddress = new CardAddress(
            new CardAddress\Address(
                new AddressOne("47A"),
                new AddressTwo("Queensbridge Road"),
                new AddressThree("Suburbia"),
                new PostalCode("CB94BQ"),
                new City("Cambridge"),
                new State("Cambridgeshire"),
                new CountryCode("GB")
            )
        );
        $cseData = new CseData($encryptedData, $cardAddress);
        $session = new Session(
            new Session\ShopperIPAddress("123.123.123.123"),
            new Session\Id("0215ui8ib1")
        );
        $paymentDetails = new PaymentDetails($cseData, $session);
        $browser = new Browser(
            new Browser\AcceptHeader("text/html"),
            new Browser\UserAgentHeader("Mozilla/5.0")
        );
        $shopper = new Shopper(
            new Shopper\ShopperEmailAddress("lpanainte+test@inviqa.com"),
            $browser
        );
        $order = new AuthorisationOrder(
            $orderCode,
            $description,
            $amount,
            $paymentDetails,
            $shopper
        );

        $paymentService = new PaymentService(
            new Version("1.4"),
            new MerchantCode("SESSIONECOM"),
            new Submit($order)
        );

        return $paymentService;
    }

    public static function simpleCsePaymentServiceRequestXml(): string
    {
        $xml = <<<XML
<paymentService version="1.4" merchantCode="SESSIONECOM">
  <submit>
    <order orderCode="order-ecomm-test-03">
      <description>test ecomm order</description>
      <amount currencyCode="GBP" exponent="2" value="1500"/>
      <paymentDetails>
        <CSE-DATA>
          <encryptedData>
            eyJhbGciOiJSU0ExXzUiLCJlbmMiOiJBMjU2R0NNIiwia2lkIjoiMSIsImNvbS53b3JsZHBheS5hcGlWZXJzaW9uIjoiMS4wIiwiY29tLndvcmxkcGF5LmxpYlZlcnNpb24iOiIxLjAuMSIsImNvbS53b3JsZHBheS5jaGFubmVsIjoiamF2YXNjcmlwdCJ9.dKfhn7pnZKfMA4Sy8ODL30o0IAsJgGkYqgaObvWpahlhW2owo-Y3xwyeXc82_kd4UJ-UN4VNxJPuENYCNEa0iq4WE_vSMiBV9d_vZK91e-lJvpHqtucc9HI0T7fh5t7-QU0qhkLj_06W57hE3-HkKhI8-ZfOLbxN0XsQk7ZFpCrK4MT-IPJTk4Twrk2b9eAbnRuTMT-mFNh8lFeZZLp42FaTuLuchPGh1SqE3ln_1oUQppnm8mYkKWNgZlY3pjFpmJFlyrhK-7y-OxVz_FtKpd79fyxtAY1nLB_WO_gmAwFVGOnKwvdsTk_FDVPZ8lRe3LRLJ7pc9gzmw8oyH1gSRQ.dTOinx-7v0pFKvhA.8ZLx2l-HUrG6rFKOqELSyCNXw69CAEvY2F1xRoSiKtiHrxvmdBs5Wz_VPwjnYEEyhf-1Brioyq6A9O0NZZgmAMwk7GBbSKmxzoszbZ-ItSRumG714iDuQ0mqAYPPkq3bxY4mNavPreBXp7eXNg.IVkvoJ3Z2iH-6XgUMDR2LQ
          </encryptedData>
          <cardAddress>
            <address>
              <address1>47A</address1>
              <address2>Queensbridge Road</address2>
              <address3>Suburbia</address3>
              <postalCode>CB94BQ</postalCode>
              <city>Cambridge</city>
              <state>Cambridgeshire</state>
              <countryCode>GB</countryCode>
            </address>
          </cardAddress>
        </CSE-DATA>
        <session shopperIPAddress="123.123.123.123" id="0215ui8ib1"/>
      </paymentDetails>
      <shopper>
        <shopperEmailAddress>lpanainte+test@inviqa.com</shopperEmailAddress>
        <browser>
          <acceptHeader>text/html</acceptHeader>
          <userAgentHeader>Mozilla/5.0</userAgentHeader>
        </browser>
      </shopper>
    </order>
  </submit>
</paymentService>
XML;

        $strippedXml = preg_replace('/\s+/', '', $xml);

        return $strippedXml;
    }

    public static function simpleCseRequestParameters(): array
    {
        return [
            'merchantCode' => 'SESSIONECOM',
            'orderCode' => 'order-ecomm-test-03',
            'description' => 'test ecomm order',
            'currencyCode' => 'GBP',
            'value' => '1500',
            'encryptedData' => 'eyJhbGciOiJSU0ExXzUiLCJlbmMiOiJBMjU2R0NNIiwia2lkIjoiMSIsImNvbS53b3JsZHBheS5hcGlWZXJzaW9uIjoiMS4wIiwiY29tLndvcmxkcGF5LmxpYlZlcnNpb24iOiIxLjAuMSIsImNvbS53b3JsZHBheS5jaGFubmVsIjoiamF2YXNjcmlwdCJ9.dKfhn7pnZKfMA4Sy8ODL30o0IAsJgGkYqgaObvWpahlhW2owo-Y3xwyeXc82_kd4UJ-UN4VNxJPuENYCNEa0iq4WE_vSMiBV9d_vZK91e-lJvpHqtucc9HI0T7fh5t7-QU0qhkLj_06W57hE3-HkKhI8-ZfOLbxN0XsQk7ZFpCrK4MT-IPJTk4Twrk2b9eAbnRuTMT-mFNh8lFeZZLp42FaTuLuchPGh1SqE3ln_1oUQppnm8mYkKWNgZlY3pjFpmJFlyrhK-7y-OxVz_FtKpd79fyxtAY1nLB_WO_gmAwFVGOnKwvdsTk_FDVPZ8lRe3LRLJ7pc9gzmw8oyH1gSRQ.dTOinx-7v0pFKvhA.8ZLx2l-HUrG6rFKOqELSyCNXw69CAEvY2F1xRoSiKtiHrxvmdBs5Wz_VPwjnYEEyhf-1Brioyq6A9O0NZZgmAMwk7GBbSKmxzoszbZ-ItSRumG714iDuQ0mqAYPPkq3bxY4mNavPreBXp7eXNg.IVkvoJ3Z2iH-6XgUMDR2LQ',
            'address1' => '47A',
            'address2' => 'Queensbridge Road',
            'address3' => 'Suburbia',
            'postalCode' => 'CB94BQ',
            'city' => 'Cambridge',
            'state' => 'Cambridgeshire',
            'countryCode' => 'GB',
            'shopperIPAddress' => '123.123.123.123',
            'email' => 'lpanainte+test@inviqa.com',
            'sessionId' => '0215ui8ib1',
            'acceptHeader' => 'text/html',
            'userAgentHeader' => 'Mozilla/5.0',
        ];
    }

    public static function simpleCseResponseXml(): string
    {
        return self::cseResponseXmlForOrderCode("order-ecomm-test-03");
    }

    public static function cseResponseXmlForOrderCode($orderCode)
    {
        $xml = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE paymentService PUBLIC "-//WorldPay//DTD WorldPay PaymentService v1//EN"
                                "http://dtd.worldpay.com/paymentService_v1.dtd">
<paymentService version="1.4" merchantCode="SESSIONECOM">
    <reply>
        <orderStatus orderCode="$orderCode">
            <payment>
                <paymentMethod>VISA-SSL</paymentMethod>
                <paymentMethodDetail>
                    <card number="4111********1111" type="creditcard">
                        <expiryDate>
                            <date month="11" year="2020"/>
                        </expiryDate>
                    </card>
                </paymentMethodDetail>
                <amount value="1500" currencyCode="GBP" exponent="2" debitCreditIndicator="credit"/>
                <lastEvent>AUTHORISED</lastEvent>
                <AuthorisationId id="830835"/>
                <CVCResultCode description="NOT SENT TO ACQUIRER"/>
                <AVSResultCode description="E"/>
                <AAVAddressResultCode description="B"/>
                <AAVPostcodeResultCode description="B"/>
                <AAVCardholderNameResultCode description="B"/>
                <AAVTelephoneResultCode description="B"/>
                <AAVEmailResultCode description="B"/>
                <cardHolderName>
                    <![CDATA[liviu]]>
                </cardHolderName>
                <issuerCountryCode>N/A</issuerCountryCode>
                <balance accountType="IN_PROCESS_AUTHORISED">
                    <amount value="1500" currencyCode="GBP" exponent="2" debitCreditIndicator="credit"/>
                </balance>
                <riskScore value="1"/>
            </payment>
        </orderStatus>
    </reply>
</paymentService>
XML;

        return $xml;
    }

    public static function cseResponseXmlWithError($errorCode, $errorMessage)
    {
$xml = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE paymentService PUBLIC "-//WorldPay//DTD WorldPay PaymentService v1//EN"
                                "http://dtd.worldpay.com/paymentService_v1.dtd">
<paymentService version="1.4" merchantCode="SESSIONECOM">
    <reply>
        <error code="$errorCode">
            <![CDATA[$errorMessage]]>
        </error>
    </reply>
</paymentService>
XML;

        return $xml;
    }

    public static function cse3DSResponseXMl($orderCode)
    {
$xml = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE paymentService PUBLIC "-//WorldPay//DTD WorldPay PaymentService v1//EN"
                                "http://dtd.worldpay.com/paymentService_v1.dtd">
<paymentService version="1.4" merchantCode="SESSIONECOM">
    <reply>
        <orderStatus orderCode='$orderCode'>
            <requestInfo>
                <request3DSecure>
                    <paRequest>eJxVUslygkAQ/ZUpzwmzKGCsdiyUVOJBNEIOOVIwJVTJ4gxEk6/PjIiYd+p+vS+wuBRH9C2kyqtyPqIWGaEFhyiTQvihSFopOGyEUvFBoDzVHjYjEzp9cV2HOiMOO28vThxuGbhOYDHAvapDZZLFZcMhTk7LdcDpAMA3Dgoh1/6jyeB58OvsUMdKnSuZcsrGE9txp4DvFJRxIXioO9V1kZ8f8iY+okioBoVZVQO+2iGp2rKRP3zKHMC9Aq088qxp6hnG5/PZUl2WtEtiJVUB2LgAHsbZtUZSOuUlT/nm17M3kUeCX48FH94j5oCNB6RxIzgjdErGxEWUzMbOjLqArzzEhemFvy13iNlPhOjddAzUppDXKcw2lkcG9IWkKJN+ol4DcamrUpgYwHcZUqES/rX93CP/NVzt17tovQ10D4YGPMy0ejcHSxq99YnGWINp9Fe7GkyJXG+PEUKvNYwC2ITi21fg2+do6d9H/QEABsjW</paRequest>
                    <issuerURL>
                        <![CDATA[https://secure-test.worldpay.com/jsp/test/shopper/ThreeDResponseSimulator.jsp?orderCode=$orderCode]]>
                    </issuerURL>
                </request3DSecure>
            </requestInfo>
            <echoData>49602206405657</echoData>
        </orderStatus>
    </reply>
</paymentService>
XML;

        return $xml;
    }

    public static function simpleCSEThreeDSPaymentService()
    {
        $orderCode = new OrderCode("order-ecomm-test-03");
        $info3DSecure = new Info3DSecure(
          new PaResonse('someparesonse')
        );
        $session = new Session(
            new Session\Id("0215ui8ib1")
        );
        $order = new AuthorisationOrder(
            $orderCode,
            $info3DSecure,
            $session
        );
        $paymentService = new PaymentService(
            new Version("1.4"),
            new MerchantCode("SESSIONECOM"),
            new Submit($order)
        );

        return $paymentService;
    }

    public static function simpleCseThreeDSRequestParameters(): array
    {
        return [
            'merchantCode' => 'SESSIONECOM',
            'orderCode'    => 'order-ecomm-test-03',
            'sessionId'    => '0215ui8ib1',
            'paResponse'   => 'someparresponse',
            'cookie'       => 'machine value'
        ];
    }
}
