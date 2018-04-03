Feature: a payment notification request is to a notification response

  Scenario: Converting a capture notification request
    When the following capture notification request is parsed
    """
<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE paymentService PUBLIC "-//Worldpay//DTD Worldpay PaymentService v1//EN"
  "http://dtd.worldpay.com/paymentService_v1.dtd">
<paymentService version="1.4" merchantCode="SESSIONECOM">
  <notify>
    <orderStatusEvent orderCode="123456"> <!--The orderCode you supplied in the order-->
      <payment>
        <paymentMethod>VISA-SSL</paymentMethod>
          <amount value="1000" currencyCode="EUR" exponent="2" debitCreditIndicator="credit"/>
        <lastEvent>CAPTURED</lastEvent>
        <reference>YourReference</reference> <!--Returned if added to capture modifications-->
        <balance accountType="IN_PROCESS_CAPTURED">
          <amount value="1000" currencyCode="EUR" exponent="2" debitCreditIndicator="credit"/>
        </balance>
        <cardNumber>5255********2490</cardNumber>
        <riskScore value="0"/>
      </payment>
      <journal journalType="CAPTURED" sent="n">
        <bookingDate>
          <date dayOfMonth="01" month="01" year="2020"/>
        </bookingDate>
        <accountTx accountType="IN_PROCESS_CAPTURED" batchId="29">
          <amount value="1000" currencyCode="EUR" exponent="2" debitCreditIndicator="credit"/>
        </accountTx>
        <accountTx accountType="IN_PROCESS_AUTHORISED" batchId="30">
          <amount value="1000" currencyCode="EUR" exponent="2" debitCreditIndicator="debit"/>
        </accountTx>
        <journalReference type="capture" reference="YourReference"/> <!--Returned if added to capture modifications-->
      </journal>
    </orderStatusEvent>
  </notify>
</paymentService>
    """
    Then a successful notification response should be returned
    And the notification response should reference the 123456 order code
    And the notification response is captured

  Scenario: Converting a refund notification request
    When the following refund notification request is parsed
    """
<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE paymentService PUBLIC "-//Worldpay//DTD Worldpay PaymentService v1//EN"
  "http://dtd.worldpay.com/paymentService_v1.dtd">
<paymentService version="1.4" merchantCode="SESSIONECOM">
  <notify>
    <orderStatusEvent orderCode="456789">
      <payment>
        <paymentMethod>VISA-SSL</paymentMethod>
          <amount value="1000" currencyCode="GBP" exponent="2" debitCreditIndicator="credit"/>
        <lastEvent>REFUNDED</lastEvent>
        <reference>{"notifyClient":true,"returnNumber":"RN0000000"}</reference>
        <balance accountType="IN_PROCESS_CAPTURED">
          <amount value="1000" currencyCode="GBP" exponent="2" debitCreditIndicator="credit"/>
        </balance>
        <cardNumber>5255********2490</cardNumber>
        <riskScore value="0"/>
      </payment>
      <journal journalType="REFUNDED" sent="n">
          <bookingDate>
            <date dayOfMonth="01" month="01" year="2020"/>
          </bookingDate>
          <accountTx accountType="SETTLED_BIBIT_NET" batchId="10">
            <amount value="900" currencyCode="GBP" exponent="2" debitCreditIndicator="debit"/>
          </accountTx>
          <accountTx accountType="IN_PROCESS_CAPTURED" batchId="17">
            <amount value="900" currencyCode="GBP" exponent="2" debitCreditIndicator="credit"/>
          </accountTx>
          <journalReference type="refund" reference=""/>
      </journal>
    </orderStatusEvent>
  </notify>
</paymentService>
    """
    Then a successful notification response should be returned
    And the notification response should reference the 456789 order code
    And the notification response is refunded
    And the notification reference is
    """
{"notifyClient":true,"returnNumber":"RN0000000"}
    """
