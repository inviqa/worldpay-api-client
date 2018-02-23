Feature: A payment authorization request is made against the Worldpay payment gateway

    Scenario: Successful payment authorization
        When I authorize the following payment
            | order_code                | 3279686                                                                |
            | description               | This is a beautiful order                                              |
            | currency_code             | GBP                                                                    |
            | value                     | 15                                                                     |
            | encrypted_data            | eyJhbGciOiJSU0ExXzUiL                                                  |
            | address1                  | 4                                                                      |
            | address2                  | Braford Gardens                                                        |
            | address3                  | Shenley Brook End                                                      |
            | postal_code               | MK137QJ                                                                |
            | city                      | Milton Keynes                                                          |
            | state                     | Buckingamshire                                                         |
            | country_code              | GB                                                                     |
            | ip_address                | 123.123.123.123                                                        |
            | session_id                | 0215ui8ib1                                                             |
            | email                     | lpanainte+test@inviqa.com                                              |
            | browser_accept_header     | text/html                                                              |
            | browser_user_agent_header | Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) |
        Then I should receive an authorized response
        And the response should reference the "3279686" order code
