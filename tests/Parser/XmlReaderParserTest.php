<?php

namespace Fxmlrpc\Serialization\Tests\Parser;

use Fxmlrpc\Serialization\Parser\XmlReaderParser;
use Fxmlrpc\Serialization\Tests\ParserTestCase;

/**
 * @author Lars Strojny <lstrojny@php.net>
 */
class XmlReaderParserTest extends ParserTestCase
{
    public function setUp()
    {
        $this->parser = new XmlReaderParser();
    }

    public function testApacheI1ExtensionValue()
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>
            <methodResponse xmlns:ext="http://ws.apache.org/xmlrpc/namespaces/extensions">
                <params>
                    <param>
                        <value>
                            <ext:i1>1</ext:i1>
                        </value>
                    </param>
                </params>
            </methodResponse>';

        $isFault = true;
        $this->assertSame(1, $this->parser->parse($xml, $isFault));
        $this->assertFalse($isFault);
    }

    public function testApacheI2ExtensionValue()
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>
            <methodResponse xmlns:ext="http://ws.apache.org/xmlrpc/namespaces/extensions">
                <params>
                    <param>
                        <value>
                            <ext:i2>1</ext:i2>
                        </value>
                    </param>
                </params>
            </methodResponse>';

        $isFault = true;
        $this->assertSame(1, $this->parser->parse($xml, $isFault));
        $this->assertFalse($isFault);
    }

    public function testApacheI8ExtensionValue()
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>
            <methodResponse xmlns:ext="http://ws.apache.org/xmlrpc/namespaces/extensions">
                <params>
                    <param>
                        <value>
                            <ext:i8>9223372036854775808</ext:i8>
                        </value>
                    </param>
                </params>
            </methodResponse>';

        $isFault = true;
        $this->assertSame('9223372036854775808', $this->parser->parse($xml, $isFault));
        $this->assertFalse($isFault);
    }

    public function testApacheBigIntegerExtensionValue()
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>
            <methodResponse xmlns:ext="http://ws.apache.org/xmlrpc/namespaces/extensions">
                <params>
                    <param>
                        <value>
                            <ext:biginteger>9223372036854775808</ext:biginteger>
                        </value>
                    </param>
                </params>
            </methodResponse>';

        $isFault = true;
        $this->assertSame('9223372036854775808', $this->parser->parse($xml, $isFault));
        $this->assertFalse($isFault);
    }

    public function testApacheBigDecimalExtensionValue()
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>
            <methodResponse xmlns:ext="http://ws.apache.org/xmlrpc/namespaces/extensions">
                <params>
                    <param>
                        <value>
                            <ext:bigdecimal>-100000000000000000.1234</ext:bigdecimal>
                        </value>
                    </param>
                </params>
            </methodResponse>';

        $isFault = true;
        $this->assertSame(-100000000000000000.1234, $this->parser->parse($xml, $isFault));
        $this->assertFalse($isFault);
    }

    public function testApacheFloatExtensionValue()
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>
            <methodResponse xmlns:ext="http://ws.apache.org/xmlrpc/namespaces/extensions">
                <params>
                    <param>
                        <value>
                            <ext:float>-100000000000000000.1234</ext:float>
                        </value>
                    </param>
                </params>
            </methodResponse>';

        $isFault = true;
        $this->assertSame(-100000000000000000.1234, $this->parser->parse($xml, $isFault));
        $this->assertFalse($isFault);
    }

    public function testApacheDomExtension()
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>
            <methodResponse xmlns:ex="http://ws.apache.org/xmlrpc/namespaces/extensions">
                <params><param><value><ex:dom><foo><bar>baz</bar></foo></ex:dom></value></param></params>
        </methodResponse>';

        $isFault = true;
        $result = $this->parser->parse($xml, $isFault);
        $this->assertInstanceOf('DOMDocument', $result);
        $this->assertXmlStringEqualsXmlString('<foo><bar>baz</bar></foo>', $result->saveXML());
        $this->assertFalse($isFault);
    }

    public function testApacheDateTimeExtension()
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>
        <methodResponse xmlns:ex="http://ws.apache.org/xmlrpc/namespaces/extensions">
            <params><param><value><ex:dateTime>2013-12-09T14:26:40.448+01:00</ex:dateTime></value></param></params>
        </methodResponse>';

        $isFault = true;
        $result = $this->parser->parse($xml, $isFault);
        $this->assertInstanceOf('DateTime', $result);
        $this->assertSame('2013-12-09T14:26:40.448000+01:00', $result->format('Y-m-d\TH:i:s.uP'));
        $this->assertFalse($isFault);
    }

    public function testEmptyArray_2()
    {
        $string = '<?xml version="1.0" encoding="UTF-8"?>
            <methodResponse>
                <params>
                    <param>
                        <value>
                            <array>
                            </array>
                        </value>
                    </param>
                </params>
            </methodResponse>';

        $isFault = true;
        $result = $this->parser->parse($string, $isFault);
        $this->assertFalse($isFault);
        $this->assertSame(array(), $result);
    }

    public function testEmptyArray_3()
    {
        $string = '<?xml version="1.0" encoding="UTF-8"?>
            <methodResponse>
                <params>
                    <param>
                        <value>
                            <array/>
                        </value>
                    </param>
                </params>
            </methodResponse>';

        $isFault = true;
        $result = $this->parser->parse($string, $isFault);
        $this->assertFalse($isFault);
        $this->assertSame(array(), $result);
    }

    public function testInvalidXml()
    {
        $string = '<?xml version="1.0" encoding="UTF-8"?>
            <methodResponse>
                <invalidTag></invalidTag>
            </methodResponse>';

        $isFault = true;

        $this->setExpectedException(
            'Fxmlrpc\Serialization\Exception\UnexpectedTagException',
            'got "invalidTag" on depth 1 (context: "<invalidTag/>")'
        );

        $this->parser->parse($string, $isFault);
    }
}
