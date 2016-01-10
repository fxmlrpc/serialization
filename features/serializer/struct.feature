Feature: struct
    In order to represent complex data structures
    As an XML-RPC client
    I need to be able to serialize array and objects

    Background:
        Given I have a call method


    Scenario: Serialize array
        And I have parameters
            """
            [
                [
                    "ONE",
                    "TWO"
                ]
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
                            <array>
                                <data>
                                    <value><string>ONE</string></value>
                                    <value><string>TWO</string></value>
                                </data>
                            </array>
                        </value>
                    </param>
                </params>
            </methodCall>
            """
        And the request should start with XML declaration


    Scenario: Serialize array with non-zero index
        And I have parameters
            """
            [
                {
                    "1": "ONE",
                    "2": "TWO"
                }
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
                            <array>
                                <data>
                                    <value><string>ONE</string></value>
                                    <value><string>TWO</string></value>
                                </data>
                            </array>
                        </value>
                    </param>
                </params>
            </methodCall>
            """
        And the request should start with XML declaration


    Scenario: Serialize array with non-zero index having gaps between indicies
        And I have parameters
            """
            [
                {
                    "1": "ONE",
                    "3": "TWO"
                }
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
                            <struct>
                                <member>
                                    <name>1</name>
                                    <value><string>ONE</string></value>
                                </member>
                                <member>
                                    <name>3</name>
                                    <value><string>TWO</string></value>
                                </member>
                            </struct>
                        </value>
                    </param>
                </params>
            </methodCall>
            """
        And the request should start with XML declaration


    Scenario: Serialize unordered array
        And I have parameters
            """
            [
                {
                    "-1": "MINUS ONE",
                    "-2": "MINUS TWO",
                    "1": "ONE"
                }
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
                            <struct>
                                <member>
                                    <name>-1</name>
                                    <value><string>MINUS ONE</string></value>
                                </member>
                                <member>
                                    <name>-2</name>
                                    <value><string>MINUS TWO</string></value>
                                </member>
                                <member>
                                    <name>1</name>
                                    <value><string>ONE</string></value>
                                </member>
                            </struct>
                        </value>
                    </param>
                </params>
            </methodCall>
            """
        And the request should start with XML declaration


    Scenario: Serialize empty array
        And I have parameters
            """
            [
                []
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
                            <array>
                                <data/>
                            </array>
                        </value>
                    </param>
                </params>
            </methodCall>
            """
        And the request should start with XML declaration


    Scenario: Serialize struct
        And I have parameters
            """
            [
                {
                    "FIRST": "ONE",
                    "SECOND": "TWO",
                    "THIRD": "THREE"
                }
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
                            <struct>
                                <member>
                                    <name>FIRST</name>
                                    <value><string>ONE</string></value>
                                </member>
                                <member>
                                    <name>SECOND</name>
                                    <value><string>TWO</string></value>
                                </member>
                                <member>
                                    <name>THIRD</name>
                                    <value><string>THREE</string></value>
                                </member>
                            </struct>
                        </value>
                    </param>
                </params>
            </methodCall>
            """
        And the request should start with XML declaration


    Scenario: Serialize object
        And I have an object parameter
            """
            {
                "FIRST": "ONE",
                "SECOND": "TWO",
                "THIRD": "THREE"
            }
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
                            <struct>
                                <member>
                                    <name>FIRST</name>
                                    <value><string>ONE</string></value>
                                </member>
                                <member>
                                    <name>SECOND</name>
                                    <value><string>TWO</string></value>
                                </member>
                                <member>
                                    <name>THIRD</name>
                                    <value><string>THREE</string></value>
                                </member>
                            </struct>
                        </value>
                    </param>
                </params>
            </methodCall>
            """
        And the request should start with XML declaration


    Scenario: Serialize array in struct
        And I have parameters
            """
            [
                {
                    "FIRST": [
                        "ONE",
                        "TWO"
                    ],
                    "SECOND": "TWO",
                    "THIRD": "THREE"
                }
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
                            <struct>
                                <member>
                                    <name>FIRST</name>
                                    <value>
                                        <array>
                                            <data>
                                                <value><string>ONE</string></value>
                                                <value><string>TWO</string></value>
                                            </data>
                                        </array>
                                    </value>
                                </member>
                                <member>
                                    <name>SECOND</name>
                                    <value><string>TWO</string></value>
                                </member>
                                <member>
                                    <name>THIRD</name>
                                    <value><string>THREE</string></value>
                                </member>
                            </struct>
                        </value>
                    </param>
                </params>
            </methodCall>
            """
        And the request should start with XML declaration


    Scenario: Serialize class
        And I have a class parameter
        When I serialize the call
        Then I should see a request
            """
            <?xml version="1.0" encoding="UTF-8"?>
            <methodCall>
                <methodName>method</methodName>
                <params>
                    <param>
                        <value>
                            <struct>
                                <member>
                                    <name>publicProperty</name>
                                    <value><string>PUBLIC</string></value>
                                </member>
                            </struct>
                        </value>
                    </param>
                </params>
            </methodCall>
            """
        And the request should start with XML declaration


    Scenario: Serialize resource
        And I have a resource parameter
        When I serialize the call
        Then I should see an error
