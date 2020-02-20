<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Inviqa\Worldpay\Api\Request\AuthorizeRequestFactory;
use Inviqa\Worldpay\Api\Request\AuthorizeRequestFactoryApplePay;
use Inviqa\Worldpay\Api\Request\AuthorizeRequestFactoryGooglePay;
use Inviqa\Worldpay\Api\Request\PaymentService;
use Inviqa\Worldpay\Api\Response\AuthorisedResponse;
use Inviqa\Worldpay\Api\Response\CancelResponse;
use Inviqa\Worldpay\Api\Response\CaptureResponse;
use Inviqa\Worldpay\Api\Response\PaymentService\Reply\OrderStatus\OrderCode;
use Inviqa\Worldpay\Api\Response\RefundResponse;
use Inviqa\Worldpay\Api\XmlNodeConverter;
use Inviqa\Worldpay\Application;
use Sabre\Xml\Writer;
use Services\TestConfig;
use Services\FakeClient;
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

    /** @var string */
    private $generatedXml;

    public function __construct()
    {
        $this->application = new Application(new TestConfig());
    }

    /**
     * @When I authorize the following payment
     */
    public function iAuthorizeTheFollowingPayment(TableNode $table)
    {
        $params = $this->paramsWithBooleanFlags($table->getRowsHash());

        if (!empty($params['shippingAddress'])) {
            $address = explode(',', $params['shippingAddress']);
            $params['shippingAddress'] = [];

            if (count($address) != 10) {
                throw new InvalidArgumentException("A shipping address must contain exactly 9 elements");
            }

            $params['shippingAddress']['firstName'] = $address[0];
            $params['shippingAddress']['lastName'] = $address[1];
            $params['shippingAddress']['address1'] = $address[2];
            $params['shippingAddress']['address2'] = $address[3];
            $params['shippingAddress']['address3'] = $address[4];
            $params['shippingAddress']['postalCode'] = $address[5];
            $params['shippingAddress']['city'] = $address[6];
            $params['shippingAddress']['state'] = $address[7];
            $params['shippingAddress']['countryCode'] = $address[8];
            $params['shippingAddress']['telephoneNumber'] = $address[9];
        }

        $this->response = $this->application->authorizePayment($params);
    }

    /**
     * @When I authorize the following payment using Apple Pay
     */
    public function iAuthorizeTheFollowingPaymentUsingApplePay(TableNode $table)
    {
        $params = $this->paramsWithBooleanFlags($table->getRowsHash());

        $this->response = $this->application->authorizeApplePayPayment($params);
    }

    /**
     * @When I authorize the following payment using Google Pay
     */
    public function iAuthorizeTheFollowingPaymentUsingGooglePay(TableNode $table)
    {
        $params = $this->paramsWithBooleanFlags($table->getRowsHash());

        $this->response = $this->application->authorizeGooglePayPayment($params);
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
            throw new InvalidArgumentException(
                sprintf(
                    "Invalid response.\nExpected '%s', got '%s'",
                    self::VALID_RESPONSE,
                    $this->response
                )
            );
        }
    }

    /**
     * @Then I should receive an authorised response
     */
    public function iShouldReceiveAnAuthorisedResponse()
    {
        if (!$this->response instanceof AuthorisedResponse) {
            throw new InvalidArgumentException(
                sprintf(
                    "Invalid response type.\nExpected '%s'\nActual '%s'",
                    AuthorisedResponse::class,
                    gettype($this->response)
                )
            );
        }
    }

    /**
     * @Then the response should reference the :orderCode order code
     */
    public function theResponseShouldReferenceTheOrderCode(OrderCode $orderCode)
    {
        if (!$orderCode->equals($this->response->orderCode())) {
            throw new InvalidArgumentException(
                sprintf(
                    "The response doesn't reference the expected order code.\nExpected '%s'\nActual '%s'",
                    $orderCode,
                    $this->response->orderCode()
                )
            );
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
     * @Then the response should contain :month as card expiry month and :year as card expiry year
     */
    public function theResponseShouldContainCardExpiryInformation($month, $year)
    {
        $cardDetails = $this->response->cardDetails();

        $this->assertCardAttributeExist(
            'expiryMonth',
            $cardDetails,
            'Card expiry month is empty.'
        );
        $this->assertCardAttributeExist(
            'expiryYear',
            $cardDetails,
            'Card expiry year is empty.'
        );
        $this->assertCardAttributeMatches('expiryMonth', $month, $cardDetails);
        $this->assertCardAttributeMatches('expiryYear', $year, $cardDetails);
    }

    /**
     * @Then the response should be an error
     */
    public function theResponseShouldBeAnError()
    {
        if (!$this->response->isError()) {
            throw new \Exception("Expected an error response, but didn't get one.");
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
            throw new InvalidArgumentException(
                sprintf(
                    "The response doesn't reference the correct error message.\nExpected '%s'\nActual '%s'",
                    $message,
                    $this->response->errorMessage()
                )
            );
        }
    }

    /**
     * @Then the response error code should be :code
     */
    public function theResponseErrorCodeShouldBe($code)
    {
        if ($this->response->errorCode() !== $code) {
            throw new InvalidArgumentException(
                sprintf(
                    "The response doesn't reference the correct error code.\nExpected '%s'\nActual '%s'",
                    $code,
                    $this->response->errorCode()
                )
            );
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
            throw new InvalidArgumentException(
                sprintf(
                    "The response doesn't reference the expected issuer URL.\nExpected '%s'\nActual '%s'",
                    $url,
                    $this->response->issuerURL()
                )
            );
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

    /**
     * @Then the raw request should match the following xml:
     */
    public function theRawRequestShouldMatchTheFollowingXml(PyStringNode $xml)
    {
        Assert::eq($this->response->rawRequestXml(), (string)$xml);
    }

    /**
     * @Given worldpay merchant account is configured to return card details
     */
    public function wordldpayMerchantAccountIsConfiguredToReturnCardDetails()
    {
        FakeClient::enableCardDetails();
    }

    /**
     * @When I generate apple pay xml with the following details
     */
    public function iGenerateApplePayXmlWithTheFollowingDetails(TableNode $table)
    {
        $params = $this->paramsWithBooleanFlags($table->getRowsHash());

        $authRequestFactory = new AuthorizeRequestFactoryApplePay();
        $xmlNodeConverter = new XmlNodeConverter(
            new Writer()
        );

        /** @var PaymentService $paymentService */
        $paymentService = $authRequestFactory->buildFromRequestParameters($params);

        $this->generatedXml = $xmlNodeConverter->toXml($paymentService);
    }

    /**
     * @When I generate google pay xml with the following details
     */
    public function iGenerateGooglePayXmlWithTheFollowingDetails(TableNode $table)
    {
        $params = $this->paramsWithBooleanFlags($table->getRowsHash());

        $authRequestFactory = new AuthorizeRequestFactoryGooglePay();
        $xmlNodeConverter = new XmlNodeConverter(
            new Writer()
        );

        /** @var PaymentService $paymentService */
        $paymentService = $authRequestFactory->buildFromRequestParameters($params);

        $this->generatedXml = $xmlNodeConverter->toXml($paymentService);
    }


    /**
     * @Then the generated XMl should match the following xml
     */
    public function theGeneratedXmlShouldMatchTheFollowingXml(PyStringNode $xml)
    {
        Assert::eq($this->generatedXml, (string)$xml);
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

    /**
     * @param string $attributeName
     * @param array $cardDetails
     * @param string $message
     *
     * @throws Exception
     */
    private function assertCardAttributeExist(string $attributeName, array $cardDetails, string $message): void
    {
        if (empty($cardDetails['creditCard'][$attributeName])) {
            throw new \Exception($message);
        }
    }

    /**
     * @param string $attributeName
     * @param mixed $expectedValue
     * @param array $cardDetails
     *
     * @throws Exception
     */
    private function assertCardAttributeMatches(string $attributeName, $expectedValue, array $cardDetails): void
    {
        if ($expectedValue !== $cardDetails['creditCard'][$attributeName]) {
            throw new \Exception(
                sprintf(
                    'Expected to get "%s" value "%s", but got "%s".',
                    $attributeName,
                    $expectedValue,
                    $cardDetails['creditCard'][$attributeName]
                )
            );
        }
    }
}
