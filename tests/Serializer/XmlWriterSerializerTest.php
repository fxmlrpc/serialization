<?php

namespace Fxmlrpc\Serialization\Tests\Serializer;

use Fxmlrpc\Serialization\ExtensionSupport;
use Fxmlrpc\Serialization\Serializer\XmlWriterSerializer;
use Fxmlrpc\Serialization\Tests\SerializerTestCase;

/**
 * @author Lars Strojny <lstrojny@php.net>
 */
class XmlWriterSerializerTest extends SerializerTestCase
{
    public function setUp()
    {
        $this->serializer = new XmlWriterSerializer();
    }

    public function testDisableNilExtension()
    {
        $this->assertInstanceOf('Fxmlrpc\Serialization\ExtensionSupport', $this->serializer);
        $nilXml = '<?xml version="1.0" encoding="UTF-8"?>
                <methodCall>
                    <methodName>method</methodName>
                    <params>
                        <param>
                            <value>
                                <nil></nil>
                            </value>
                        </param>
                    </params>
                </methodCall>';

        $this->assertXmlStringEqualsXmlString($nilXml, $this->serializer->serialize('method', [null]));
        $this->assertNull($this->serializer->disableExtension(ExtensionSupport::EXTENSION_NIL));

        $stringXml = '<?xml version="1.0" encoding="UTF-8"?>
                <methodCall>
                    <methodName>method</methodName>
                    <params>
                        <param>
                            <value>
                                <string></string>
                            </value>
                        </param>
                    </params>
                </methodCall>';

        $this->assertXmlStringEqualsXmlString($stringXml, $this->serializer->serialize('method', [null]));
    }
}
