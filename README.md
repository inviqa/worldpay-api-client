# Worldpay API Client

[ ![Codeship Status for inviqa/worldpay-api-client](https://app.codeship.com/projects/a13b5690-fe9e-0135-5a6d-462e71abe528/status?branch=master)](https://app.codeship.com/projects/279504)

The purpose of this library is to abstract payment requests performed against the Worldpay XML API.

## Supported payment requests and planned features
- [x] Payment authorization with Client Side Encryption token
- [x] 3D Secure support
- [x] Payment capture
- [x] Payment refund
- [x] Payment cancellation

## How to perform an authorization request using a Client Side Encrypted token

### Create a class that implements the `Inviqa\Worldpay\Config` interface. See example below:
```php
class MyConfig implements Inviqa\Worldpay\Config
{
    public function isTestMode(): bool { return false; }
    public function username(): string { return "insert_username"; }
    public function password(): string { return "insert_password"; }
    public function uri(): string { return "insert_api_endpoint"; }
}
````

### Instantiate the library application class and inject an instance of the above configuration
```php
$app = new Inviqa\Worldpay\Application(
    new MyConfig()
);
```

### Send the request as an array of parameters
```php
$requestParams = [
    'orderCode' => '123456',
    'description' => 'Some description',
    'currencyCode' => 'GBP',
    'value' => '1500',
    'encryptedData' => 'ajfhlgskjdfghsljh',
    'address1' => '7',
    'address2' => 'Kempock St', # optional field
    'address3' => 'Greenock', # optional field
    'postalCode' => 'PA19 1NF',
    'city' => 'Greenock',
    'state' => 'Renfrewshire',
    'countryCode' => 'GB',
    'shopperIPAddress' => '192.168.0.1',
    'email' => 'tim.webster@inviqa.com',
    'sessionId' => '123456',
    'acceptHeader' => 'header',
    'userAgentHeader' => 'agent',
    'encryptedToken' => '123456',
    'merchantCode' => 'SESSIONECOM'
];

try {
    $response = $app->authorizePayment($requestParams);
    
    if ($response->isSuccessful()) {
        echo "The payment has been successfully authorized";
    } else {
        echo "The payment could not be authorized. Error message: " . $response->errorMessage();
    }
} catch (WorldpayException $e) {
    // this exception can include network connectivity issues or validation errors
}
```

## How to run the automated test suite
```bash
bin/phpspec r
bin/behat
```
