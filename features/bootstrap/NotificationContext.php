<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Inviqa\Worldpay\Application;
use Inviqa\Worldpay\Notification\Response\JournalTransaction;
use Inviqa\Worldpay\Notification\Response\NotificationResponse;
use Services\TestConfig;
use Webmozart\Assert\Assert;

class NotificationContext implements Context
{
    /**
     * @var Application
     */
    private $application;

    /** @var null|NotificationResponse */
    private $response;

    public function __construct()
    {
        $this->application = new Application(new TestConfig());
    }

    /**
     * @When the following notification request is parsed
     */
    public function theFollowingNotificationRequestIsParsed(PyStringNode $notification)
    {
        $this->response = $this->application->parseNotification($notification);
    }

    /**
     * @Then a successful notification response should be returned
     */
    public function aSuccessfulNotificationResponseShouldBeReturned()
    {
        Assert::isInstanceOf($this->response,NotificationResponse::class);
        Assert::true($this->response->isSuccessful());
    }

    /**
     * @Then the notification response should reference the :orderCode order code
     */
    public function theNotificationResponseShouldReferenceTheOrderCode($orderCode)
    {
        Assert::eq($this->response->orderCode(), $orderCode);
    }

    /**
     * @Then the notification response is captured
     */
    public function theNotificationResponseIsCaptured()
    {
        Assert::true($this->response->isCaptured());
    }

    /**
     * @Then the notification response is capture failed
     */
    public function theNotificationResponseIsCaptureFailed()
    {
        Assert::true($this->response->isCaptureFailed());
    }

    /**
     * @Then the notification response is refunded
     */
    public function theNotificationResponseIsRefunded()
    {
        Assert::true($this->response->isRefunded());
    }

    /**
     * @Then the notification response is refund failed
     */
    public function theNotificationResponseIsRefundFailed()
    {
        Assert::true($this->response->isRefundFailed());
    }

    /**
     * @Then the notification reference is :reference
     */
    public function theNotificationReferenceIs(string $reference)
    {
        Assert::eq($this->response->reference(), $reference);
    }

    /**
     * @Then the following journal transactions are available:
     */
    public function jorunalTranscations(TableNode $table)
    {
        foreach ($table->getColumnsHash() as $expectedTransaction) {
            $transaction = $this->response->transactions()->oneByType($expectedTransaction['type']);
            Assert::isInstanceOf($transaction, JournalTransaction::class);
            Assert::eq($transaction->getAmount(), $expectedTransaction['amount']);
        }
    }
}
