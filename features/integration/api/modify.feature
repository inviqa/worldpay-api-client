Feature: Payment modification requests are made against the Worldpay payment gateway

    Scenario: Successful capture request
        When I send the following capture modification
            | merchantCode | SESSIONECOM |
            | orderCode    | 32796901    |
            | currencyCode | GBP         |
            | amount       | 15          |
        Then I should receive a capture response
        And the response should be successful
        And the response should reference the "32796901" order code

    Scenario: Successful refund request
        When I send the following refund modification
            | merchantCode | SESSIONECOM |
            | orderCode    | 32796901    |
            | currencyCode | GBP         |
            | amount       | 15          |
        Then I should receive a refund response
        And the response should be successful
        And the response should reference the "32796901" order code
