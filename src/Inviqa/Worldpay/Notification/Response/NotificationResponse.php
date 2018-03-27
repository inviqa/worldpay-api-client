<?php

namespace Inviqa\Worldpay\Notification\Response;

class NotificationResponse
{
    const EVENT_CAPTURED = "CAPTURED";
    const EVENT_REFUNDED = "REFUNDED";
    /**
     * @var string
     */
    private $rawNotification;

    private function __construct()
    {
    }

    public static function fromRawNotification(string $rawNotification = "")
    {
        $instance = new NotificationResponse();
        $instance->rawNotification = $rawNotification;

        return $instance;
    }

    public function isSuccessful(): bool
    {
        return strlen($this->nodeValue("lastEvent")) > 0;
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

    public function orderCode(): string
    {
        return $this->nodeAttributeValue("orderStatusEvent", "orderCode");
    }

    public function isCaptured()
    {
        return $this->nodeValue("lastEvent") === self::EVENT_CAPTURED;
    }

    public function isRefunded()
    {
        return $this->nodeValue("lastEvent") === self::EVENT_REFUNDED;
    }

    public function rawNotification()
    {
        return $this->rawNotification;
    }

    public function refundValue()
    {
        $xml = simplexml_load_string($this->rawNotification);

        return (int) $xml->notify->orderStatusEvent->journal->accountTx[0]->amount->attributes()['value'];
    }

    public function returnNumber()
    {
        $xml = simplexml_load_string($this->rawNotification);

        $reference = unserialize($xml->notify->orderStatusEvent->journal->journalReference->attributes()['reference']);

        return $reference['returnNumber'] ?: '';
    }

    public function notifyClient()
    {
        $xml = simplexml_load_string($this->rawNotification);

        $reference = unserialize($xml->notify->orderStatusEvent->journal->journalReference->attributes()['reference']);

        return $reference['notifyClient'] ?: false;
    }
}
