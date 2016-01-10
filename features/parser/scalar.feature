Feature: scalar
    In order to represent simple data
    As an XML-RPC client
    I need to be able to parse scalar values


    Scenario: Parse string value
        Given I have a response with a value Value of type string
        When I parse the response
        Then I should see the value Value
        But there should be no fault


    Scenario: Parse string value with special characters
        Given I have a response with a value "foo &amp; bar" of type string
        When I parse the response
        Then I should see the value "foo & bar"
        But there should be no fault


    Scenario: Parse string value with special and numeric characters
        Given I have a response with a value "1 &gt; 2" of type string
        When I parse the response
        Then I should see the value "1 > 2"
        But there should be no fault


    Scenario: Parse string value with special alpha-numeric characters
        Given I have a response with a value "&#220;ml&#228;uts" of type string
        When I parse the response
        Then I should see the value "Ümläuts"
        But there should be no fault


    Scenario: Parse i4 value
        Given I have a response with a value 12 of type i4
        When I parse the response
        Then I should see the value 12
        But there should be no fault


    Scenario: Parse int value
        Given I have a response with a value 12 of type int
        When I parse the response
        Then I should see the value 12
        But there should be no fault


    Scenario: Parse a negative-signed i4 value
        Given I have a response with a value "-4" of type i4
        When I parse the response
        Then I should see the value "-4"
        But there should be no fault


    Scenario: Parse a negative-signed int value
        Given I have a response with a value "-4" of type int
        When I parse the response
        Then I should see the value "-4"
        But there should be no fault


    Scenario: Parse a positive-signed i4 value
        Given I have a response with a value "+4" of type i4
        When I parse the response
        Then I should see the value 4
        But there should be no fault


    Scenario: Parse a positive-signed int value
        Given I have a response with a value "+4" of type int
        When I parse the response
        Then I should see the value 4
        But there should be no fault


    Scenario: Parse a zero padded i4 value
        Given I have a response with a value 000004 of type i4
        When I parse the response
        Then I should see the value 4
        But there should be no fault


    Scenario: Parse a false boolean value
        Given I have a response with a value 0 of type boolean
        When I parse the response
        Then I should see the value false
        But there should be no fault


    Scenario: Parse a true boolean value
        Given I have a response with a value 1 of type boolean
        When I parse the response
        Then I should see the value true
        But there should be no fault


    Scenario: Parse double value
        Given I have a response with a value 1.2 of type double
        When I parse the response
        Then I should see the value 1.2
        But there should be no fault

    Scenario: Parse negative-signed double value
        Given I have a response with a value "-1.2" of type double
        When I parse the response
        Then I should see the value "-1.2"
        But there should be no fault


    Scenario: Parse positive-signed double value
        Given I have a response with a value "+1.2" of type double
        When I parse the response
        Then I should see the value 1.2
        But there should be no fault


    Scenario: Parse datetime value
        Given I have a response with a value "19980717T14:08:55" of type dateTime.iso8601
        When I parse the response
        Then I should see a datetime value "1998-07-17 14:08:55"
        But there should be no fault


    Scenario: Parse base64 value
        Given I have a response with a value Zm9vYmFy of type base64
        When I parse the response
        Then I should see a base64 value foobar
        But there should be no fault


    Scenario: Parse empty string tag
        Given I have a response with an empty tag of type string
        When I parse the response
        Then I should see an empty value
        But there should be no fault


    Scenario: Parse empty i4 tag
        Given I have a response with an empty tag of type i4
        When I parse the response
        Then I should see an empty value
        But there should be no fault


    Scenario: Parse empty int tag
        Given I have a response with an empty tag of type int
        When I parse the response
        Then I should see an empty value
        But there should be no fault


    Scenario: Parse empty boolean tag
        Given I have a response with an empty tag of type boolean
        When I parse the response
        Then I should see an empty value
        But there should be no fault


    Scenario: Parse empty double tag
        Given I have a response with an empty tag of type double
        When I parse the response
        Then I should see an empty value
        But there should be no fault


    Scenario: Parse empty string value
        Given I have a response with an empty value of type string
        When I parse the response
        Then I should see an empty value
        But there should be no fault


    Scenario: Parse empty i4 value
        Given I have a response with an empty value of type i4
        When I parse the response
        Then I should see an empty value
        But there should be no fault


    Scenario: Parse empty int value
        Given I have a response with an empty value of type int
        When I parse the response
        Then I should see an empty value
        But there should be no fault


    Scenario: Parse empty boolean value
        Given I have a response with an empty value of type boolean
        When I parse the response
        Then I should see an empty value
        But there should be no fault


    Scenario: Parse empty double value
        Given I have a response with an empty value of type double
        When I parse the response
        Then I should see an empty value
        But there should be no fault


    Scenario: Parse string value with a space
        Given I have a response with a value " " of type string
        When I parse the response
        Then I should see the value " "
        But there should be no fault


    Scenario: Parse implicit string value
        Given I have a response with a value STRING
        When I parse the response
        Then I should see the value "STRING"
        But there should be no fault


    Scenario: Parse base64 value including newlines as in Python XML-RPC
        Given I have a response
            """
            <?xml version='1.0'?>
            <methodResponse>
                <params>
                    <param>
                        <value>
                            <base64>
                            SEVMTE8gV09STEQ=
                            </base64>
                        </value>
                    </param>
                </params>
            </methodResponse>
            """
        When I parse the response
        Then I should see a base64 value "HELLO WORLD"
        But there should be no fault


    @zend_incompatible
    Scenario: Parse invalid multiple parameters
        Given I have a response
            """
            <?xml version='1.0'?>
            <methodResponse>
                <params>
                    <param>
                        <value>p1</value>
                    </param>
                    <param>
                        <value>p2</value>
                    </param>
                    <param>
                        <value>p3</value>
                    </param>
                </params>
            </methodResponse>
            """
        When I parse the response
        Then I should see the value p3
        But there should be no fault


    @nil
    Scenario: Parse nil value
        Given I have a response
            """
            <?xml version="1.0" encoding="UTF-8"?>
            <methodResponse>
                <params>
                    <param>
                        <value>
                            <nil/>
                        </value>
                    </param>
                </params>
            </methodResponse>
            """
        When I parse the response
        Then I should see a null value
        But there should be no fault


    @nil @zend_incompatible
    Scenario: Parse Apache nil value
        Given I have a response
            """
            <?xml version="1.0" encoding="UTF-8"?>
            <methodResponse xmlns:ext="http://ws.apache.org/xmlrpc/namespaces/extensions">
                <params>
                    <param>
                        <value>
                            <ext:nil/>
                        </value>
                    </param>
                </params>
            </methodResponse>
            """
        When I parse the response
        Then I should see a null value
        But there should be no fault

