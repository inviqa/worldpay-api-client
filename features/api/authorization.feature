Feature: A payment authorization request is made against the Worldpay payment gateway

  Scenario: Successful payment authorization
    When I authorize the following payment
      | merchantCode     | SESSIONECOM                                                            |
      | orderCode        | 3279686                                                                |
      | description      | This is a beautiful order                                              |
      | currencyCode     | GBP                                                                    |
      | value            | 15                                                                     |
      | encryptedData    | eyJhbGciOiJSU0ExXzUiL                                                  |
      | address1         | 4                                                                      |
      | address2         | Braford Gardens                                                        |
      | address3         | Shenley Brook End                                                      |
      | postalCode       | MK137QJ                                                                |
      | city             | Milton Keynes                                                          |
      | state            | Buckingamshire                                                         |
      | countryCode      | GB                                                                     |
      | shopperIPAddress | 123.123.123.123                                                        |
      | sessionId        | 0215ui8ib1                                                             |
      | email            | lpanainte+test@inviqa.com                                              |
      | acceptHeader     | text/html                                                              |
      | userAgentHeader  | Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) |
    Then I should receive an authorised response
    And the response should reference the "3279686" order code
