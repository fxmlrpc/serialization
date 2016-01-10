Feature: fault
    In order to handle faulty cases
    As an XML-RPC client
    I need to be able to parse faults


    Scenario: Parse fault
        Given I have a response
            """
            <?xml version="1.0" encoding="UTF-8"?>
            <methodResponse>
                <fault>
                    <value>
                        <struct>
                            <member>
                                <name>faultCode</name>
                                <value><int>123</int></value>
                            </member>
                            <member>
                                <name>faultString</name>
                                <value><string>ERROR</string></value>
                            </member>
                        </struct>
                    </value>
                </fault>
            </methodResponse>
            """
        When I parse the response
        Then I should see a structure matching JSON
            """
            {
                "faultCode": 123,
                "faultString": "ERROR"
            }
            """
        And there should be a fault

