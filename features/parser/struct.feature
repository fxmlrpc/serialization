Feature: struct
    In order to represent complex data structures
    As an XML-RPC client
    I need to be able to parse structs in a response


    Scenario: Parse simple struct
        Given I have a response
            """
            <?xml version="1.0" encoding="UTF-8"?>
            <methodResponse>
                <params>
                    <param>
                        <value>
                            <struct>
                                <member>
                                    <name>FIRST</name>
                                    <value><string>ONE</string></value>
                                </member>
                                <member>
                                    <value><string>TWO</string></value>
                                    <name>SECOND</name>
                                </member>
                                <member>
                                    <name>THIRD</name>
                                    <value><string>THREE</string></value>
                                </member>
                            </struct>
                        </value>
                    </param>
                </params>
            </methodResponse>
            """
        When I parse the response
        Then I should see a structure matching JSON
            """
            {
                "FIRST": "ONE",
                "SECOND": "TWO",
                "THIRD": "THREE"
            }
            """
        But there should be no fault


    Scenario: Parse nested structs
        Given I have a response
            """
            <?xml version="1.0" encoding="UTF-8"?>
            <methodResponse>
                <params>
                    <param>
                        <value>
                            <struct>
                                <member>
                                    <name>FIRST</name>
                                    <value>
                                        <struct>
                                            <member>
                                                <name>ONE</name>
                                                <value><i4>1</i4></value>
                                            </member>
                                            <member>
                                                <name>TWO</name>
                                                <value><i4>2</i4></value>
                                            </member>
                                        </struct>
                                    </value>
                                </member>
                                <member>
                                    <name>SECOND</name>
                                    <value>
                                        <struct>
                                            <member>
                                                <name>ONE ONE</name>
                                                <value><i4>11</i4></value>
                                            </member>
                                            <member>
                                                <name>TWO TWO</name>
                                                <value><i4>22</i4></value>
                                            </member>
                                        </struct>
                                    </value>
                                </member>
                            </struct>
                        </value>
                    </param>
                </params>
            </methodResponse>
            """
        When I parse the response
        Then I should see a structure matching JSON
            """
            {
                "FIRST": {
                    "ONE": 1,
                    "TWO": 2
                },
                "SECOND": {
                    "ONE ONE": 11,
                    "TWO TWO": 22
                }
            }
            """
        But there should be no fault


    Scenario: Parse lists in structs
        Given I have a response
            """
            <?xml version="1.0" encoding="UTF-8"?>
            <methodResponse>
                <params>
                    <param>
                        <value>
                            <struct>
                                <member>
                                    <name>FIRST</name>
                                    <value>
                                        <array>
                                            <data>
                                                <value>
                                                    <array>
                                                        <data>
                                                            <value><string> Str 00</string></value>
                                                            <value><string> Str 01</string></value>
                                                        </data>
                                                    </array>
                                                </value>
                                                <value>
                                                    <array>
                                                        <data>
                                                            <value><string> Str 10</string></value>
                                                            <value><string> Str 11</string></value>
                                                        </data>
                                                    </array>
                                                </value>
                                            </data>
                                        </array>
                                    </value>
                                </member>
                                <member>
                                    <name>SECOND</name>
                                    <value>
                                        <array>
                                            <data>
                                                <value>
                                                    <array>
                                                        <data>
                                                            <value><string>Str 30</string></value>
                                                            <value><string>Str 31</string></value>
                                                        </data>
                                                    </array>
                                                </value>
                                                <value>
                                                    <array>
                                                        <data>
                                                            <value><string>Str 40</string></value>
                                                            <value><string>Str 41</string></value>
                                                        </data>
                                                    </array>
                                                </value>
                                            </data>
                                        </array>
                                    </value>
                                </member>
                            </struct>
                        </value>
                    </param>
                </params>
            </methodResponse>
            """
        When I parse the response
        Then I should see a structure matching JSON
            """
            {
                "FIRST": [
                    [" Str 00", " Str 01"],
                    [" Str 10", " Str 11"]
                ],
                "SECOND": [
                    ["Str 30", "Str 31"],
                    ["Str 40", "Str 41"]
                ]
            }
            """
        But there should be no fault


    Scenario: Parse empty struct
        Given I have a response
            """
            <?xml version="1.0" encoding="UTF-8"?>
            <methodResponse>
                <params>
                    <param>
                        <value>
                            <struct>
                            </struct>
                        </value>
                    </param>
                </params>
            </methodResponse>
            """
        When I parse the response
        Then I should see a structure matching JSON
            """
            {}
            """
        But there should be no fault


    Scenario: Parse empty struct (self-closing tag)
        Given I have a response
            """
            <?xml version="1.0" encoding="UTF-8"?>
            <methodResponse>
                <params>
                    <param>
                        <value>
                            <struct/>
                        </value>
                    </param>
                </params>
            </methodResponse>
            """
        When I parse the response
        Then I should see a structure matching JSON
            """
            {}
            """
        But there should be no fault


    Scenario: Parse struct with empty member
        Given I have a response
            """
            <?xml version="1.0" encoding="UTF-8"?>
            <methodResponse>
                <params>
                    <param>
                        <value>
                            <struct>
                                <member>
                                    <name>FIRST</name>
                                    <value></value>
                                </member>
                            </struct>
                        </value>
                    </param>
                </params>
            </methodResponse>
            """
        When I parse the response
        Then I should see a structure matching JSON
            """
            {
                "FIRST": ""
            }
            """
        But there should be no fault
