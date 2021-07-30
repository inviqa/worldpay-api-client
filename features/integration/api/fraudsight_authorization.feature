Feature: A payment authorization request is made against the Worldpay payment using 3DS Flex

    Scenario: Successful payment authorization with not requiring 3DS flex challenge
        When I authorize the following payment
            | merchantCode        | REISSECOMGBP                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     |
            | orderCode           | 77766633301                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      |
            | description         | This is a beautiful order                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        |
            | currencyCode        | GBP                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              |
            | value               | 15                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               |
            | encryptedData       | eyJhbGciOiJSU0ExXzUiLCJlbmMiOiJBMjU2R0NNIiwia2lkIjoiMSIsImNvbS53b3JsZHBheS5hcGlWZXJzaW9uIjoiMS4wIiwiY29tLndvcmxkcGF5LmxpYlZlcnNpb24iOiIxLjAuMSIsImNvbS53b3JsZHBheS5jaGFubmVsIjoiamF2YXNjcmlwdCJ9.dRLdwIEaFobISQRn7Nw_CSuDPcdyD_ssic5NWP838bEnqqaiv1NROkM_hEzGssVXIS4384vtmgc7ZeScIaNAuckEGeA3L8Fr_ucpxCtS0w05VadzqzQLSX1SOFDRnWxjBKh2zX2JpPOPBjXZXpIwwTx4k3jxaxbqzjAzcz2IgpDvIVHJGJ45ziRD8H9LmjN_3sx-cFLEzDpsproz9VuioRtV2tFe0hWSxxA1dGOhS0renspASmmMWznfAv48tDMPkGDBQeCUkCFEdy5fyTP6vwo__eLWwDWThexPI750MH6yDAb6ZMlN_DcN-B3MDjYRNx9tuJK9uYZVOKx1HM8pvg.H5bv_exIuNXZcZ6c.Ly05HljJ_2d68dRATe2uKH6eN1qdE-AOWj0YRIMFsyCumH4QbVh4X_y0KGfcb9ORCLxEhCIF3Nfw5GZYW3FCecT24zpAljHfeVQjHmZxAcYB2BxuTfpkdCnGG4e6SD5Ohg60Gy-34P-fbcj4.tBCqnBmDyNeS8ZDxtYCGpQ |
            | customerId          | 123456                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              |
            | firstName           | Tim                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              |
            | lastName            | Webster                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          |
            | address1            | 4                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                |
            | address2            | Braford Gardens                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  |
            | address3            | Shenley Brook End                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                |
            | postalCode          | MK137QJ                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          |
            | city                | Milton Keynes                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    |
            | state               | Buckingamshire                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   |
            | countryCode         | GB                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               |
            | telephoneNumber     | 07426000000                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      |
            | shopperIPAddress    | 123.123.123.123                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  |
            | sessionId           | 0215ui8ib1                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       |
            | email               | lpanainte+test@inviqa.com                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        |
            | acceptHeader        | text/html                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        |
            | userAgentHeader     | Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko)                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           |
            | RGProfileID         | 201477                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           |
            | shippingMethod      | UK Next Day                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      |
            | checkoutMethod      | Registered                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       |
            | orderSource         |                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  |
            | paymentSubtype      |                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  |
            | ageOfAccount        | 4.5678                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           |
            | timeSinceLastOrder  | 3.4567                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           |
            | numberPurchases     | 5                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                |
            | productRisk         | false                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            |
            | numberStyles        | 2                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                |
            | numberSkus          | 3                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                |
            | numberUnits         | 3                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                |
            | numberHighRiskUnits | 0                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                |
            | shippingAddress     | Tim,Webster,7,Crisswell Close,Crownhill,PA16 0XA,Milton Keynes,Bucks,GB,07426111111                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              |
            | dfReferenceId       | 0_76607b65-03a2-45da-bf3c-858b1ea54f2c                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           |
            | fsSession           | 465c8d58-2cd1-4d2e-9a52-201449b6c043                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             |
            | birthday            | 29,10,1979                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       |
        Then I should receive an authorised response
        And the response should be successful
        And the response should reference the "77766633301" order code
        And the response should reference a valid machine cookie
        And the raw request should match the following xml:
"""
<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE paymentService PUBLIC "-//Worldpay//DTD Worldpay PaymentService v1//EN" "http://dtd.worldpay.com/paymentService_v1.dtd"><paymentService version="1.4" merchantCode="REISSECOMGBP">
 <submit>
  <order orderCode="77766633301">
   <description>This is a beautiful order</description>
   <amount currencyCode="GBP" exponent="2" value="15"/>
   <paymentDetails>
    <CSE-DATA>
     <encryptedData>eyJhbGciOiJSU0ExXzUiLCJlbmMiOiJBMjU2R0NNIiwia2lkIjoiMSIsImNvbS53b3JsZHBheS5hcGlWZXJzaW9uIjoiMS4wIiwiY29tLndvcmxkcGF5LmxpYlZlcnNpb24iOiIxLjAuMSIsImNvbS53b3JsZHBheS5jaGFubmVsIjoiamF2YXNjcmlwdCJ9.dRLdwIEaFobISQRn7Nw_CSuDPcdyD_ssic5NWP838bEnqqaiv1NROkM_hEzGssVXIS4384vtmgc7ZeScIaNAuckEGeA3L8Fr_ucpxCtS0w05VadzqzQLSX1SOFDRnWxjBKh2zX2JpPOPBjXZXpIwwTx4k3jxaxbqzjAzcz2IgpDvIVHJGJ45ziRD8H9LmjN_3sx-cFLEzDpsproz9VuioRtV2tFe0hWSxxA1dGOhS0renspASmmMWznfAv48tDMPkGDBQeCUkCFEdy5fyTP6vwo__eLWwDWThexPI750MH6yDAb6ZMlN_DcN-B3MDjYRNx9tuJK9uYZVOKx1HM8pvg.H5bv_exIuNXZcZ6c.Ly05HljJ_2d68dRATe2uKH6eN1qdE-AOWj0YRIMFsyCumH4QbVh4X_y0KGfcb9ORCLxEhCIF3Nfw5GZYW3FCecT24zpAljHfeVQjHmZxAcYB2BxuTfpkdCnGG4e6SD5Ohg60Gy-34P-fbcj4.tBCqnBmDyNeS8ZDxtYCGpQ</encryptedData>
     <cardAddress>
      <address>
       <firstName>Tim</firstName>
       <lastName>Webster</lastName>
       <address1>4</address1>
       <address2>Braford Gardens</address2>
       <address3>Shenley Brook End</address3>
       <postalCode>MK137QJ</postalCode>
       <city>Milton Keynes</city>
       <state>Buckingamshire</state>
       <countryCode>GB</countryCode>
       <telephoneNumber>07426000000</telephoneNumber>
      </address>
     </cardAddress>
    </CSE-DATA>
    <session shopperIPAddress="123.123.123.123" id="0215ui8ib1"/>
   </paymentDetails>
   <shopper>
    <shopperEmailAddress>lpanainte+test@inviqa.com</shopperEmailAddress>
    <browser>
     <acceptHeader>text/html</acceptHeader>
     <userAgentHeader>Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko)</userAgentHeader>
    </browser>
   </shopper>
   <shippingAddress>
    <address>
     <firstName>Tim</firstName>
     <lastName>Webster</lastName>
     <address1>7</address1>
     <address2>Crisswell Close</address2>
     <address3>Crownhill</address3>
     <postalCode>PA16 0XA</postalCode>
     <city>Milton Keynes</city>
     <state>Bucks</state>
     <countryCode>GB</countryCode>
     <telephoneNumber>07426111111</telephoneNumber>
    </address>
   </shippingAddress>
   <hcgAdditionalData>
    <param name="RGProfileID">201477</param>
    <param name="xField1">UK Next Day</param>
    <param name="xField2">normal</param>
    <param name="xField3"></param>
    <param name="xField4">Registered</param>
    <param name="xField5"></param>
    <param name="xField6"></param>
    <param name="nField1">4.5678</param>
    <param name="nField2">3.4567</param>
    <param name="nField3">5</param>
    <param name="nField4">2</param>
    <param name="nField5">3</param>
    <param name="nField6">3</param>
    <param name="nField7">0</param>
   </hcgAdditionalData>
   <additional3DSData dfReferenceId="0_76607b65-03a2-45da-bf3c-858b1ea54f2c" challengeWindowSize="fullPage"/>
   <fraudSightData>
    <shopperFields>
     <shopperName>Tim Webster</shopperName>
     <shopperId>123456</shopperId>
     <birthDate>
      <date dayOfMonth="29" month="10" year="1979"/>
     </birthDate>
     <shopperAddress>
      <address>
       <firstName>Tim</firstName>
       <lastName>Webster</lastName>
       <address1>4</address1>
       <address2>Braford Gardens</address2>
       <address3>Shenley Brook End</address3>
       <postalCode>MK137QJ</postalCode>
       <city>Milton Keynes</city>
       <countryCode>GB</countryCode>
       <telephoneNumber>07426000000</telephoneNumber>
      </address>
     </shopperAddress>
    </shopperFields>
   </fraudSightData>
   <deviceSession>
    <sessionId>465c8d58-2cd1-4d2e-9a52-201449b6c043</sessionId>
   </deviceSession>
  </order>
 </submit>
</paymentService>

"""