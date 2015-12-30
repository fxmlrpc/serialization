<?php

namespace Fxmlrpc\Serialization\Tests\Serializer;

use Fxmlrpc\Serialization\Serializer\Zend1Serializer;
use Fxmlrpc\Serialization\Tests\SerializerTestCase;
use Fxmlrpc\Serialization\Value\Base64Value;

/**
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class Zend1SerializerTest extends SerializerTestCase
{
    public function setUp()
    {
        $this->serializer = new Zend1Serializer();
    }

    public function provideTypes()
    {
        return [
            ['string', 'test string', 'test string'],
            ['int', 2, '2'],
            ['int', -2, '-2'],
            ['double', 1.2, '1.2'],
            ['double', -1.2, '-1.2'],
            ['boolean', true, '1'],
            ['boolean', false, '0'],
            [
                'dateTime.iso8601',
                \DateTime::createFromFormat('Y-m-d H:i:s', '1998-07-17 14:08:55', new \DateTimeZone('UTC')),
                '19980717T14:08:55'
            ],
            ['base64', Base64Value::serialize('string'), "c3RyaW5n"], // http://php.net/manual/en/function.xmlrpc-encode-request.php#27992
            ['string', 'Ümläuts', '&#220;ml&#228;uts'],
        ];
    }

    /**
     * TODO: is "<params/>" mandatory?
     */
    public function testSerializingMethodCallWithoutArguments()
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>
                <methodCall>
                    <methodName>method</methodName>
                </methodCall>';

        $this->assertXmlStringEqualsXmlString($xml, $this->serializer->serialize('method'));
    }
}
