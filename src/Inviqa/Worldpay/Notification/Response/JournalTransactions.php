<?php

namespace Inviqa\Worldpay\Notification\Response;

use ArrayIterator;
use Iterator;
use IteratorAggregate;

class JournalTransactions implements IteratorAggregate
{
    private $transactions;

    /**
     * @param JournalTransaction[] $transactions
     */
    public function __construct(array $transactions)
    {
        $this->transactions = $transactions;
    }

    public function getIterator(): Iterator
    {
        return new ArrayIterator($this->transactions);
    }

    public function oneByType(string $type): ?JournalTransaction
    {
        foreach ($this->transactions as $transaction) {
            if ($transaction->getType() === $type) {
                return $transaction;
            }
        }

        return null;
    }
}
