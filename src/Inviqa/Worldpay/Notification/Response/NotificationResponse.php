<?php

namespace Inviqa\Worldpay\Notification\Response;

class NotificationResponse
{
    const EVENT_CAPTURED = "CAPTURED";
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
}
