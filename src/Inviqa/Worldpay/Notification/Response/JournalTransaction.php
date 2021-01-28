<?php

namespace Inviqa\Worldpay\Notification\Response;

class JournalTransaction
{
    /**
     * @var string
     */
    private $type;
    /**
     * @var int
     */
    private $amount;

    public function __construct(string $type, int $amount)
    {
        $this->type = $type;
        $this->amount = $amount;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }
}
