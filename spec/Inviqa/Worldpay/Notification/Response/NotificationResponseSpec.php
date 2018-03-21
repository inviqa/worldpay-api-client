<?php

namespace spec\Inviqa\Worldpay\Notification\Response;

use Inviqa\Worldpay\Notification\Response\NotificationResponse;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class NotificationResponseSpec extends ObjectBehavior
{
    const RAW_NOTIFICATION = '
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
    function it_returns_true_if_a_captured_event_is_available()
    {
        $this->beConstructedFromRawNotification(self::RAW_NOTIFICATION);

        $this->isSuccessful()->shouldBe(true);
    }

    function it_returns_the_order_code()
    {
        $this->beConstructedFromRawNotification(self::RAW_NOTIFICATION);

        $this->orderCode()->shouldBe("123456");
    }

    function it_returns_true_when_the_last_event_is_captured()
    {
        $this->beConstructedFromRawNotification(self::RAW_NOTIFICATION);

        $this->isCaptured()->shouldBe(true);
    }
}
