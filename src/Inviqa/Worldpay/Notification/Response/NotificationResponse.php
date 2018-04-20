<?php

namespace Inviqa\Worldpay\Notification\Response;

class NotificationResponse
{
    const EVENT_CAPTURED = "CAPTURED";
    const EVENT_CAPTURE_FAILED = "CAPTURE_FAILED";
    const EVENT_SENT_FOR_REFUND = "SENT_FOR_REFUND";
    const EVENT_REFUND_FAILED = "REFUND_FAILED";

    /**
     * @var string
     */
    private $rawNotification;

    public static function fromRawNotification(string $rawNotification = "")
    {
        $instance                  = new NotificationResponse();
        $instance->rawNotification = $rawNotification;

        return $instance;
    }

    public function isSuccessful(): bool
    {
        return strlen($this->nodeValue("lastEvent")) > 0;
    }

    public function orderCode(): string
    {
        return $this->nodeAttributeValue("orderStatusEvent", "orderCode");
    }

    public function isCaptured()
    {
        return $this->nodeValue("lastEvent") === self::EVENT_CAPTURED;
    }

    public function isCaptureFailed()
    {
        return $this->nodeValue("lastEvent") === self::EVENT_CAPTURE_FAILED;
    }

    public function isRefunded()
    {
        return $this->nodeValue("lastEvent") === self::EVENT_SENT_FOR_REFUND;
    }

    public function isRefundFailed()
    {
        return $this->nodeValue("lastEvent") === self::EVENT_REFUND_FAILED;
    }

    public function rawNotification()
    {
        return $this->rawNotification;
    }

    public function refundValue()
    {
        $xml = simplexml_load_string(self::rawNotification());

        return (int)$xml->notify->orderStatusEvent->journal->accountTx[0]->amount->attributes()['value'];
    }

    public function reference()
    {
        return $this->nodeValue('reference');
    }

    private function nodeValue(string $nodeName): string
    {
        if (preg_match("~$nodeName>([^<]+)</$nodeName~", $this->rawNotification, $matches)) {
            return $matches[1];
        }

        return '';
    }

    private function nodeAttributeValue(string $nodeName, string $attributeName): string
    {
        if (preg_match("~<$nodeName.*$attributeName=['\"]([^'\"]*)['\"]/?>~", $this->rawNotification, $matches)) {
            return $matches[1];
        }

        return '';
    }

    private function __construct()
    {
    }
}
