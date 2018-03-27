<?php

namespace spec\Inviqa\Worldpay\Notification\Response;

use Inviqa\Worldpay\Notification\Response\NotificationResponse;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class NotificationResponseSpec extends ObjectBehavior
{
    const CAPTURED_NOTIFICATION = '
<paymentService version="1.4" merchantCode="SESSIONECOM">
  <notify>
    <orderStatusEvent orderCode="123456"> <!--The orderCode you supplied in the order-->
      <payment>
        <paymentMethod>VISA-SSL</paymentMethod>
          <amount value="1000" currencyCode="EUR" exponent="2" debitCreditIndicator="credit"/>
        <lastEvent>CAPTURED</lastEvent>
        <riskScore value="0"/>
      </payment>
      <journal journalType="CAPTURED" sent="n"></journal>
    </orderStatusEvent>
  </notify>
</paymentService>
';

    const REFUNDED_NOTIFICATION = '
<paymentService version="1.4" merchantCode="SESSIONECOM"> 
  <notify>
    <orderStatusEvent orderCode="123456">
      <payment>
        <paymentMethod>VISA-SSL</paymentMethod>
          <amount value="1000" currencyCode="GBP" exponent="2" debitCreditIndicator="credit"/>
        <lastEvent>REFUNDED</lastEvent>
        <reference>a:2:{s:12:"returnNumber";s:2:"R1";s:12:"notifyClient";b:1;}</reference>
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
          <journalReference type="refund" reference=\'a:2:{s:12:"returnNumber";s:2:"R1";s:12:"notifyClient";b:1;}\'/>
      </journal> 
    </orderStatusEvent>
  </notify>
</paymentService>
';

    function it_returns_true_if_a_captured_event_is_available()
    {
        $this->beConstructedFromRawNotification(self::CAPTURED_NOTIFICATION);

        $this->isSuccessful()->shouldBe(true);
    }

    function it_returns_the_order_code()
    {
        $this->beConstructedFromRawNotification(self::CAPTURED_NOTIFICATION);

        $this->orderCode()->shouldBe("123456");
    }

    function it_returns_true_when_the_last_event_is_captured()
    {
        $this->beConstructedFromRawNotification(self::CAPTURED_NOTIFICATION);

        $this->isCaptured()->shouldBe(true);
    }

    function it_returns_true_if_a_refunded_event_is_available()
    {
        $this->beConstructedFromRawNotification(self::REFUNDED_NOTIFICATION);

        $this->isSuccessful()->shouldBe(true);
    }

    function it_returns_true_when_the_last_event_is_refunded()
    {
        $this->beConstructedFromRawNotification(self::REFUNDED_NOTIFICATION);

        $this->isRefunded()->shouldBe(true);
    }

    function it_returns_the_refund_value_from_the_journal_node_in_the_notification()
    {
        $this->beConstructedFromRawNotification(self::REFUNDED_NOTIFICATION);

        $this->refundValue()->shouldBe(900);
    }

    function it_returns_the_return_number_from_the_journal_reference_node_in_the_notification()
    {
        $this->beConstructedFromRawNotification(self::REFUNDED_NOTIFICATION);

        $this->returnNumber()->shouldBe('R1');
    }

    function it_returns_the_notify_client_variable_from_the_journal_reference_node_in_the_notification()
    {
        $this->beConstructedFromRawNotification(self::REFUNDED_NOTIFICATION);

        $this->notifyClient()->shouldBe(true);
    }
}
