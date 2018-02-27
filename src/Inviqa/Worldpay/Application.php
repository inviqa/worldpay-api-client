<?php

namespace Inviqa\Worldpay;

use Inviqa\Worldpay\Api\Exception\WorldpayException;
use Inviqa\Worldpay\Api\PaymentAuthorizer;
use Inviqa\Worldpay\Api\Request\RequestFactory;
use Inviqa\Worldpay\Api\Response\AuthorisedResponse;
use Inviqa\Worldpay\Api\XmlNodeConverter;
use Sabre\Xml\Writer;
use Services\FakeClient;

class Application
{
    private $paymentAuthorizer;

    public function __construct($testMode = false)
    {
        $this->paymentAuthorizer = new PaymentAuthorizer(
            new RequestFactory(),
            new XmlNodeConverter(
                new Writer()
            ),
            new FakeClient()
        );
    }

    /**
     * @param array $paymentParameters
     * @return AuthorisedResponse
     *
     * @throws WorldpayException
     */
    public function authorizePayment(array $paymentParameters)
    {
        return $this->paymentAuthorizer->authorizePayment($paymentParameters);
    }
}
