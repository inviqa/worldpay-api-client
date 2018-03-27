<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Inviqa\Worldpay\Application;
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
     * @When the following capture notification request is parsed
     * @When the following refund notification request is parsed
     */
    public function theFollowingCaptureNotificationRequestIsParsed(PyStringNode $notification)
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
     * @Then the notification response is refunded
     */
    public function theNotificationResponseIsRefunded()
    {
        Assert::true($this->response->isRefunded());
    }

    /**
     * @Then the notification return number is :returnNumber
     */
    public function theNotificationReturnNumberIs($returnNumber)
    {
        Assert::eq($this->response->returnNumber(), $returnNumber);
    }

    /**
     * @Then the notifcation notify client is :notifyClient
     */
    public function theNotifcationNotifyClientIs2($notifyClient)
    {
        Assert::true($this->response->notifyClient());
    }

}
