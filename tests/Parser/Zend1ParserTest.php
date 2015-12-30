<?php

namespace Fxmlrpc\Serialization\Tests\Parser;

use Fxmlrpc\Serialization\Parser\Zend1Parser;
use Fxmlrpc\Serialization\Tests\ParserTestCase;
use Fxmlrpc\Serialization\Value\Base64;
use Fxmlrpc\Serialization\Value\Base64Value;

/**
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class Zend1ParserTest extends ParserTestCase
{
    public function setUp()
    {
        $this->parser = new Zend1Parser();
    }

    public static function provideSimpleTypes()
    {
        return [
            ['Value', 'string', 'Value'],
            ['foo & bar', 'string', 'foo &amp; bar'],
            ['1 > 2', 'string', '1 &gt; 2'],
            [12, 'i4', '12'],
            [12, 'int', '12'],
            [-4, 'int', ' -4 '],
            [-4, 'i4', ' -4'],
            [4, 'int', ' +4 '],
            [4, 'i4', '  +4  '],
            [4, 'i4', '000004'],
            [false, 'boolean', '0'],
            [true, 'boolean', '1'],
            [1.2, 'double', '1.2'],
            [1.2, 'double', '+1.2'],
            [-1.2, 'double', '-1.2'],
            [
                \DateTime::createFromFormat('Y-m-d H:i:s', '1998-07-17 14:08:55', new \DateTimeZone('UTC')),
                'dateTime.iso8601',
                '19980717T14:08:55',
                function ($v) { if ($v instanceof \DateTime) { return $v->format('Ymd\TH:i:s'); } return $v; }, // Zend automatically decodes datetime
            ],
            [
                Base64Value::deserialize('Zm9vYmFy'),
                'base64',
                'Zm9vYmFy',
                function ($v) { if ($v instanceof Base64) { return $v->getDecoded(); } return $v; }, // Zend automatically decodes base64
            ],
            ['Ümläuts', 'string', '&#220;ml&#228;uts'],
        ];
    }

    public function testParsingBase64WithNewlinesAsPythonXmlRpcEncodes()
    {
        $xml = "<?xml version='1.0'?>
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
        </methodResponse>";

        $value = $this->parser->parse($xml, $isFault);
        $this->assertSame('HELLO WORLD', $value); // Zend automatically decodes base64
//        $this->assertSame('SEVMTE8gV09STEQ=', $value->getEncoded());

        $this->assertFalse($isFault);
    }

    /**
     * @dataProvider provideSimpleTypes
     */
    public function testEmptyTags($expectedValue, $serializedType)
    {
        $expectedValue = null;

        // Zend 1 does not support empty datetime
        if ($serializedType === 'dateTime.iso8601') {
            $expectedValue = (new \DateTime())->format('Ymd\TH:i:s');
        }

        $xml = sprintf(
            '<?xml version="1.0" encoding="UTF-8"?>
                <methodResponse>
                <params>
                    <param>
                    <value><%1$s></%1$s></value>
                    </param>
                </params>
                </methodResponse>',
            $serializedType
        );

        $isFault = true;
        $this->assertEquals($expectedValue, $this->parser->parse($xml, $isFault));
        $this->assertFalse($isFault);
    }

    /**
     * @dataProvider provideSimpleTypes
     */
    public function testEmptyValue($expectedValue, $serializedType)
    {
        $expectedValue = null;

        // Zend 1 does not support empty datetime
        if ($serializedType === 'dateTime.iso8601') {
            $expectedValue = (new \DateTime())->format('Ymd\TH:i:s');
        }

        $xml = sprintf('<?xml version="1.0" encoding="UTF-8"?>
                <methodResponse>
                <params>
                    <param>
                        <value>
                            <%s/>
                        </value>
                    </param>
                </params>
                </methodResponse>',
            $serializedType
        );

        $isFault = true;
        $this->assertEquals($expectedValue, $this->parser->parse($xml, $isFault));
        $this->assertFalse($isFault);
    }

    public function testApacheNilExtensionValue()
    {
        $this->markTestSkipped('Zend 1 does not support Apache Nil');
    }

    public function testParsingInvalidMultipleParams()
    {
        $xml = "<?xml version='1.0'?>
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
        </methodResponse>";

        $value = $this->parser->parse($xml, $isFault);
        $this->assertSame('p1', $value); // TODO: which is the correct behavior?

        $this->assertFalse($isFault);
    }

    public function testXmlComments()
    {
        $this->markTestSkipped('Zend 1 does not support XML Comments');
    }

    public function testXxeAttack_1()
    {
        $xml = '<?xml version="1.0" encoding="ISO-8859-7"?>
            <!DOCTYPE foo [<!ENTITY xxefca0a SYSTEM "file:///etc/passwd">]>
            <methodResponse>
                <params>
                    <param><value>&xxefca0a;</value></param>
                </params>
            </methodResponse>';

        $this->parser->parse($xml, $isFault);
        $this->assertTrue($isFault); // Zend 1 fails to parse this response
    }
}
