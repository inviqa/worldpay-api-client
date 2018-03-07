<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Inviqa\Worldpay\Api\Response\AuthorisedResponse;
use Inviqa\Worldpay\Api\Response\PaymentService\Reply\OrderStatus\OrderCode;
use Inviqa\Worldpay\Application;
use Services\TestConfig;

class ApiContext implements Context
{
    const VALID_RESPONSE = "OK";

    /**
     * @var Application
     */
    private $application;

    /**
     * @var AuthorisedResponse
     */
    private $response;

    public function __construct()
    {
        $this->application = new Application(new TestConfig());
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
                "The response doesn't reference the expected order code.\nExpected '%s'\nActual '%s'",
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

    /**
     * @Then the response should be successful
     */
    public function theResponseShouldBeSuccessful()
    {
        if (!$this->response->isSuccessful()) {
            throw new \Exception("Expected a successful response, but got an unsuccessful one.");
        }
    }

    /**
     * @Then the response should not be successful
     */
    public function theResponseShouldNotBeSuccessful()
    {
        if ($this->response->isSuccessful()) {
            throw new \Exception("Did not expect a successful response, but got one.");
        }
    }

    /**
     * @Then the response error message should be :message
     */
    public function theResponseErrorMessageShouldBe($message)
    {
        if ($this->response->errorMessage() !== $message) {
            throw new InvalidArgumentException(sprintf(
                "The response doesn't reference the correct error message.\nExpected '%s'\nActual '%s'",
                $message,
                $this->response->errorMessage()
            ));
        }
    }

    /**
     * @Then the response error code should be :code
     */
    public function theResponseErrorCodeShouldBe($code)
    {
        if ($this->response->errorCode() !== $code) {
            throw new InvalidArgumentException(sprintf(
                "The response doesn't reference the correct error code.\nExpected '%s'\nActual '%s'",
                $code,
                $this->response->errorCode()
            ));
        }
    }


    /**
     * @Then I should receive a 3d secure response
     */
    public function iShouldReceiveA3DSecureResponse()
    {
        if (!$this->response->is3DSecure()) {
            throw new \Exception("Expected a 3D Secure response, but got one.");
        }
    }

    /**
     * @Then the response should reference a valid :node value
     */
    public function theResponseShouldReferenceAValidValue($node)
    {
        if (strlen($this->response->paRequestValue()) === 0) {
            throw new InvalidArgumentException(
                "The response doesn't reference a valid paRequest value.\nExpected non-empty string. \nActual ''"
            );
        }
    }

    /**
     * @Then the response should reference the following issuerURL: :arg1
     */
    public function theResponseShouldReferenceTheFollowingIssuerurl($url)
    {
        if ($this->response->issuerURL() !== $url) {
            throw new InvalidArgumentException(sprintf(
                "The response doesn't reference the expected issuer URL.\nExpected '%s'\nActual '%s'",
                $url,
                $this->response->issuerURL()
            ));
        }
    }
}
