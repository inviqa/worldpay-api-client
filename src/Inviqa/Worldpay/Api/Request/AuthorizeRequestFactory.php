<?php

namespace Inviqa\Worldpay\Api\Request;

use Inviqa\Worldpay\Api\Exception\InvalidRequestParameterException;
use Inviqa\Worldpay\Api\Request\PaymentService\MerchantCode;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\AuthorisationOrder;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\Description;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\OrderCode;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\CseData;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\CseData\EncryptedData;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetails\Session;
use Inviqa\Worldpay\Api\Request\PaymentService\Submit\Authorisation\Order\PaymentDetailsWorldpay;
use Inviqa\Worldpay\Api\Request\PaymentService\Version;
use Inviqa\Worldpay\Config;

class AuthorizeRequestFactory implements RequestFactory
{
    /**
     * @var Config
     */
    private $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    const DEFAULT_PARAMETERS = [
        'version' => "1.4",
        'orderCode' => "",
        'description' => "",
        'currencyCode' => "",
        'exponent' => "2",
        'value' => "",
        'encryptedData' => "",
        'address1' => "",
        'address2' => "",
        'address3' => "",
        'postalCode' => "",
        'city' => "",
        'state' => "",
        'countryCode' => "",
        'telephoneNumber' => "",
        'shopperIPAddress' => "",
        'email' => "",
        'sessionId' => "",
        'acceptHeader' => "",
        'userAgentHeader' => "",
        'dynamic3DS' => false,
        'RGProfileID' => "",
        'shippingMethod' => "",
        'checkoutMethod' => "",
        'orderSource' => "",
        'paymentSubtype' => "",
        'ageOfAccount' => "",
        'timeSinceLastOrder' => "",
        'numberPurchases' => "",
        'productRisk' => false,
        'numberStyles' => "",
        'numberSkus' => "",
        'numberUnits' => "",
        'numberHighRiskUnits' => "",
        'shippingAddress' => null,
    ];

    const DEFAULT_ADDRESS_PARAMETERS = [
        'address1' => "",
        'address2' => "",
        'address3' => "",
        'postalCode' => "",
        'city' => "",
        'state' => "",
        'countryCode' => "",
        'telephoneNumber' => "",
    ];

    /**
     * @param array $parameters
     * @return PaymentService
     *
     * @throws InvalidRequestParameterException
     */
    public function buildFromRequestParameters(array $parameters): PaymentService
    {
        if (!empty($parameters['shippingAddress'])) {
            $parameters['shippingAddress'] += self::DEFAULT_ADDRESS_PARAMETERS;
        }
        $parameters += self::DEFAULT_PARAMETERS;
        $treeBuilder = new AuthoriseRequestTreeBuilder($parameters, $this->config);

        $orderCode = new OrderCode($parameters['orderCode']);
        $description = new Description($parameters['description']);
        $amount = $treeBuilder->buildAmount($parameters);
        $encryptedData = new EncryptedData($parameters['encryptedData']);
        $cardAddress = $treeBuilder->buildCardAddress();
        $cseData = new CseData($encryptedData, $cardAddress);
        $session = new Session(new Session\Id($parameters['sessionId']));

        if ($parameters['shopperIPAddress']) {
            $session = $session->withShopperIPAddress(new Session\ShopperIPAddress($parameters['shopperIPAddress']));
        }

        $paymentDetails = new PaymentDetailsWorldpay($cseData, $session);
        $shopper = $treeBuilder->buildShopper();

        $hcgAdditionalData = $treeBuilder->buildHcgAdditionalData();

        $order = new AuthorisationOrder(
            $orderCode,
            $description,
            $amount,
            $paymentDetails,
            $shopper,
            $hcgAdditionalData
        );

        $order = $treeBuilder->buildAdditionalOrderDetails($parameters, $order);

        return new PaymentService(
            new Version($parameters['version']),
            new MerchantCode($parameters['merchantCode']),
            new Submit($order)
        );
    }
}
