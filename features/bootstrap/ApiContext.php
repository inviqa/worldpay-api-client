<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Inviqa\Worldpay\Api\Response\AuthorisedResponse;
use Inviqa\Worldpay\Api\Response\CancelResponse;
use Inviqa\Worldpay\Api\Response\CaptureResponse;
use Inviqa\Worldpay\Api\Response\PaymentService\Reply\OrderStatus\OrderCode;
use Inviqa\Worldpay\Api\Response\RefundResponse;
use Inviqa\Worldpay\Application;
use Services\TestConfig;
use Webmozart\Assert\Assert;

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
        $this->response = $this->application->authorizePayment(
            $this->paramsWithBooleanFlags($table->getRowsHash())
        );
    }

    /**
     * @When the authorization for the following payment is completed
     */
    public function theAuthorizationForTheFollowingPaymentIsCompleted(TableNode $table)
    {
        $this->response = $this->application->completePaymentAuthorization(
            $this->paramsWithBooleanFlags($table->getRowsHash())
        );
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
            throw new \Exception("Expected a 3D Secure response, but didn't get one.");
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

    /**
     * @Then the response should reference a valid machine cookie
     */
    public function theResponseShouldReferenceAValidMachineCookie()
    {
        if (!$this->response->machineCookie()) {
            throw new InvalidArgumentException("The response doesn't reference a valid machine cookie.");
        }
    }

    /**
     * @When I send the following capture modification
     */
    public function iSendTheFollowingCaptureModification(TableNode $table)
    {
        $this->response = $this->application->capturePayment(
            $this->paramsWithBooleanFlags($table->getRowsHash())
        );
    }

    /**
     * @Then I should receive a capture response
     */
    public function iShouldReceiveAnCaptureResponse()
    {
        Assert::isInstanceOf($this->response, CaptureResponse::class);
    }

    /**
     * @When I send the following refund modification
     */
    public function iSendTheFollowingRefundModification(TableNode $table)
    {
        $this->response = $this->application->refundPayment(
            $this->paramsWithBooleanFlags($table->getRowsHash())
        );
    }

    /**
     * @Then I should receive a refund response
     */
    public function iShouldReceiveAnRefundResponse()
    {
        Assert::isInstanceOf($this->response, RefundResponse::class);
    }

    /**
     * @When I send the following cancel modification
     */
    public function iSendTheFollowingCancelModification(TableNode $table)
    {
        $this->response = $this->application->cancelPayment(
            $this->paramsWithBooleanFlags($table->getRowsHash())
        );
    }

    /**
     * @Then I should receive a cancel response
     */
    public function iShouldReceiveACancelResponse()
    {
        Assert::isInstanceOf($this->response, CancelResponse::class);
    }


    private function paramsWithBooleanFlags(array $paymentParameters): array
    {
        foreach ($paymentParameters as $key => $param) {
            if ($param == "true") {
                $paymentParameters[$key] = true;
            }

            if ($param == "false") {
                $paymentParameters[$key] = false;
            }
        }

        return $paymentParameters;
    }
}
