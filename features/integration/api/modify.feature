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

    Scenario: Successful cancel request
        When I send the following cancel modification
            | merchantCode | SESSIONECOM |
            | orderCode    | 32796901    |
            | currencyCode | GBP         |
            | amount       | 15          |
        Then I should receive a cancel response
        And the response should be successful
        And the response should reference the "32796901" order code

    Scenario: Successful void request
        When I send the following void modification
            | merchantCode | SESSIONECOM |
            | orderCode    | 32796901    |
            | currencyCode | GBP         |
            | amount       | 15          |
        Then I should receive a void response
        And the response should be successful
        And the response should reference the "32796901" order code

    Scenario: Successful multi-capture request
        When I send the following capture modification
            | merchantCode | SESSIONECOM |
            | orderCode    | 32796901    |
            | currencyCode | GBP         |
            | amount       | 15          |
            | reference    | 1234        |
        Then I should receive a capture response
        And the response should be successful
        And the response should reference the "32796901" order code
