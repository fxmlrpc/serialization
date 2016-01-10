Feature: fault
    In order to deal with XML Entities
    As an XML-RPC client
    I need to be able to parse XML Entities


    Scenario: Parse predefined name
        Given I have a response with a value "&amp;&apos;&lt;&gt;" of type string
        When I parse the response
        Then I should see the value "&'<>"
        But there should be no fault


    Scenario: Parse predefined value
        Given I have a response with a value "&#38;&#39;&#60;&#62;" of type string
        When I parse the response
        Then I should see the value "&'<>"
        But there should be no fault


    Scenario: Parse numeric Unicode entities
        Given I have a response with a value "&#916;&#1049;&#1511;&#1605;&#3671;&#12354;&#21494;&#33865;&#47568;" of type string
        When I parse the response
        Then I should see the value "ΔЙקم๗あ叶葉말"
        But there should be no fault


    Scenario: Parse hexadecimal Unicode entities
        Given I have a response with a value "&#x394;&#x419;&#x5E7;&#x645;&#xE57;&#x3042;&#x53F6;&#x8449;&#xB9D0;" of type string
        When I parse the response
        Then I should see the value "ΔЙקم๗あ叶葉말"
        But there should be no fault


    @zend_incompatible
    Scenario: Parse XML comments
        Given I have a response
            """
            <?xml version="1.0" encoding="UTF-8"?>
            <!-- Comment -->
            <methodResponse>
                <!-- Comment -->
                <params>
                <!-- Comment -->
                    <param>
                    <!-- Comment -->
                        <value>
                        <!-- Comment -->
                            <string>value</string>
                        <!-- Comment -->
                        </value>
                    <!-- Comment -->
                    </param>
                <!-- Comment -->
                </params>
            <!-- Comment -->
            </methodResponse>
            <!-- Comment -->
            """
        When I parse the response
        Then I should see the value value
        But there should be no fault


    @zend_incompatible
    Scenario: Parse an XXE attack
        Given I have a response
            """
            <?xml version="1.0" encoding="ISO-8859-7"?>
            <!DOCTYPE foo [<!ENTITY xxefca0a SYSTEM "file:///etc/passwd">]>
            <methodResponse>
                <params>
                    <param><value>&xxefca0a;</value></param>
                </params>
            </methodResponse>
            """
        When I parse the response
        Then I should see an empty value
        But there should be no fault
