Feature: scalar
    In order to represent data
    As an XML-RPC client
    I need to be able to serialize scalar values


    Background:
        Given I have a call method


    Scenario: Serialize string value
        Given I have a parameter "test string"
        When I serialize the call
        Then I should see a request with the parameter "test string" of type string
        And the request should start with XML declaration


    Scenario: Serialize string value with special characters
        Given I have a parameter "Ümläuts"
        When I serialize the call
        Then I should see a request with the parameter "&#220;ml&#228;uts" of type string
        And the request should start with XML declaration


    Scenario: Serialize integer value
        Given I have a parameter 2 of type int
        When I serialize the call
        Then I should see a request with the parameter 2 of type int
        And the request should start with XML declaration


    Scenario: Serialize negative integer value
        Given I have a parameter "-2" of type int
        When I serialize the call
        Then I should see a request with the parameter "-2" of type int
        And the request should start with XML declaration


    Scenario: Serialize double value
        Given I have a parameter 1.2 of type float
        When I serialize the call
        Then I should see a request with the parameter 1.2 of type double
        And the request should start with XML declaration


    Scenario: Serialize negative double value
        Given I have a parameter "-1.2" of type float
        When I serialize the call
        Then I should see a request with the parameter "-1.2" of type double
        And the request should start with XML declaration


    Scenario: Serialize boolean value
        Given I have a parameter true of type bool
        When I serialize the call
        Then I should see a request with the parameter 1 of type boolean
        And the request should start with XML declaration


    Scenario: Serialize boolean value
        Given I have a parameter false of type bool
        When I serialize the call
        Then I should see a request with the parameter 0 of type boolean
        And the request should start with XML declaration


    Scenario: Serialize datetime value
        Given I have a datetime parameter "1998-07-17 14:08:55"
        When I serialize the call
        Then I should see a request with the parameter "19980717T14:08:55" of type "dateTime.iso8601"
        And the request should start with XML declaration


    Scenario: Serialize base64 value
        Given I have a base64 parameter string
        When I serialize the call
        Then I should see a request with the parameter "c3RyaW5n" of type "base64"
        And the request should start with XML declaration


    Scenario: Serialize multiple string values
        Given I have a parameter "test string"
        And I have a parameter "test string"
        And I have a parameter "test string"
        When I serialize the call
        Then I should see a request with the parameter "test string" of type string
        And the request should start with XML declaration


    Scenario: Serialize multiple string values with special characters
        Given I have a parameter "Ümläuts"
        And I have a parameter "Ümläuts"
        And I have a parameter "Ümläuts"
        When I serialize the call
        Then I should see a request with the parameter "&#220;ml&#228;uts" of type string
        And the request should start with XML declaration


    Scenario: Serialize multiple integer values
        Given I have a parameter 2 of type int
        And I have a parameter 2 of type int
        And I have a parameter 2 of type int
        When I serialize the call
        Then I should see a request with the parameter 2 of type int
        And the request should start with XML declaration


    Scenario: Serialize multiple negative integer values
        Given I have a parameter "-2" of type int
        And I have a parameter "-2" of type int
        And I have a parameter "-2" of type int
        When I serialize the call
        Then I should see a request with the parameter "-2" of type int
        And the request should start with XML declaration


    Scenario: Serialize multiple double values
        Given I have a parameter 1.2 of type float
        And I have a parameter 1.2 of type float
        And I have a parameter 1.2 of type float
        When I serialize the call
        Then I should see a request with the parameter 1.2 of type double
        And the request should start with XML declaration


    Scenario: Serialize multiple negative double values
        Given I have a parameter "-1.2" of type float
        And I have a parameter "-1.2" of type float
        And I have a parameter "-1.2" of type float
        When I serialize the call
        Then I should see a request with the parameter "-1.2" of type double
        And the request should start with XML declaration


    Scenario: Serialize multiple boolean values
        Given I have a parameter true of type bool
        And I have a parameter true of type bool
        And I have a parameter true of type bool
        When I serialize the call
        Then I should see a request with the parameter 1 of type boolean
        And the request should start with XML declaration


    Scenario: Serialize multiple boolean values
        Given I have a parameter false of type bool
        And I have a parameter false of type bool
        And I have a parameter false of type bool
        When I serialize the call
        Then I should see a request with the parameter 0 of type boolean
        And the request should start with XML declaration


    Scenario: Serialize multiple datetime values
        Given I have a datetime parameter "1998-07-17 14:08:55"
        And I have a datetime parameter "1998-07-17 14:08:55"
        And I have a datetime parameter "1998-07-17 14:08:55"
        When I serialize the call
        Then I should see a request with the parameter "19980717T14:08:55" of type "dateTime.iso8601"
        And the request should start with XML declaration


    Scenario: Serialize multiple base64 values
        Given I have a base64 parameter string
        And I have a base64 parameter string
        And I have a base64 parameter string
        When I serialize the call
        Then I should see a request with the parameter "c3RyaW5n" of type "base64"
        And the request should start with XML declaration


    @zend_incompatible
    Scenario: Serialize call without parameters
        When I serialize the call
        Then I should see a request
            """
            <?xml version="1.0" encoding="UTF-8"?>
            <methodCall>
                <methodName>method</methodName>
                <params/>
            </methodCall>
            """
        And the request should start with XML declaration


    Scenario: Serialize string parameter
        And I have parameters
            """
            [
                " TESTSTR "
            ]
            """
        When I serialize the call
        Then I should see a request
            """
            <?xml version="1.0" encoding="UTF-8"?>
            <methodCall>
                <methodName>method</methodName>
                <params>
                    <param>
                        <value>
                            <string> TESTSTR </string>
                        </value>
                    </param>
                </params>
            </methodCall>
            """
        And the request should start with XML declaration


    Scenario: Serialize multiple string parameters
        And I have parameters
            """
            [
                " TESTSTR1 ",
                " TESTSTR2 "
            ]
            """
        When I serialize the call
        Then I should see a request
            """
            <?xml version="1.0" encoding="UTF-8"?>
            <methodCall>
                <methodName>method</methodName>
                <params>
                    <param>
                        <value>
                            <string> TESTSTR1 </string>
                        </value>
                    </param>
                    <param>
                        <value>
                            <string> TESTSTR2 </string>
                        </value>
                    </param>
                </params>
            </methodCall>
            """
        And the request should start with XML declaration
