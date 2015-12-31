Feature: array
    In order to represent data structures
    As an XML-RPC client
    I need to be able to parse array in a response


    Scenario: Parse list
        Given I have a response
            """
            <?xml version="1.0" encoding="UTF-8"?>
            <methodResponse>
                <params>
                    <param>
                        <value>
                            <array>
                                <data>
                                    <value><string>Str 0</string></value>
                                    <value><string>Str 1</string></value>
                                </data>
                            </array>
                        </value>
                    </param>
                </params>
            </methodResponse>
            """
        When I parse the response
        Then I should see a structure matching JSON
            """
            [
                "Str 0",
                "Str 1"
            ]
            """
        But there should be no fault


    Scenario: Parse nested list
        Given I have a response
            """
            <?xml version="1.0" encoding="UTF-8"?>
            <methodResponse>
                <params>
                    <param>
                        <value>
                            <array>
                                <data>
                                    <value>
                                        <array>
                                            <data>
                                                <value><string>Str 00</string></value>
                                                <value><string>Str 01</string></value>
                                            </data>
                                        </array>
                                    </value>
                                    <value>
                                        <array>
                                            <data>
                                                <value><string>Str 10</string></value>
                                                <value><string>Str 11</string></value>
                                            </data>
                                        </array>
                                    </value>
                                </data>
                            </array>
                        </value>
                    </param>
                </params>
            </methodResponse>
            """
        When I parse the response
        Then I should see a structure matching JSON
            """
            [
                [
                    "Str 00",
                    "Str 01"
                ],
                [
                    "Str 10",
                    "Str 11"
                ]
            ]
            """
        But there should be no fault


    Scenario: Parse empty array
        Given I have a response
            """
            <?xml version="1.0" encoding="UTF-8"?>
            <methodResponse>
                <params>
                    <param>
                        <value>
                            <array>
                                <data/>
                            </array>
                        </value>
                    </param>
                </params>
            </methodResponse>
            """
        When I parse the response
        Then I should see a structure matching JSON
            """
            []
            """
        But there should be no fault
