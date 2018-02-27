<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Inviqa\Worldpay\Api\Response\AuthorisedResponse;
use Inviqa\Worldpay\Api\Response\PaymentService\Reply\OrderStatus\OrderCode;
use Inviqa\Worldpay\Api\Response\Response;
use Inviqa\Worldpay\Application;

class ApiContext implements Context
{
    const VALID_RESPONSE = "OK";

    private $application;

    private $response;

    public function __construct()
    {
        $this->application = new Application();
    }

    /**
     * @When I authorize the following payment
     */
    public function iAuthorizeTheFollowingPayment(TableNode $table)
    {
        $this->response = $this->application->authorizePayment($table->getRowsHash());
    }

    /**
     * @Then I should receive a successful response
     */
    public function iShouldReceiveASuccessfulResponse()
    {
        if ($this->response !== self::VALID_RESPONSE) {
            throw new InvalidArgumentException(sprintf(
                "Invalid response.\nExpected '%s', got '%s'",
                self::VALID_RESPONSE,
                $this->response
            ));
        }
    }

    /**
     * @Then I should receive an authorised response
     */
    public function iShouldReceiveAnAuthorisedResponse()
    {
        if (!$this->response instanceof AuthorisedResponse) {
            throw new InvalidArgumentException(sprintf(
                "Invalid response type.\nExpected '%s'\nActual '%s'",
                AuthorisedResponse::class,
                gettype($this->response)
            ));
        }
    }

    /**
     * @Then the response should reference the :orderCode order code
     */
    public function theResponseShouldReferenceTheOrderCode(OrderCode $orderCode)
    {
        if (!$orderCode->equals($this->response->orderCode())) {
            throw new InvalidArgumentException(sprintf(
                "The response doesn't reference the expected order code..\nExpected '%s'\nActual '%s'",
                $orderCode,
                $this->response->orderCode()
            ));
        }
    }

    /**
     * @Transform :orderCode
     */
    public function fromStringToOrderCode($orderCode)
    {
        return new OrderCode($orderCode);
    }

}
