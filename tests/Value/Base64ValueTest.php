<?php

namespace fXmlRpc\Serialization\Tests\Value;

use fXmlRpc\Serialization\Value\Base64Value;

/**
 * @author Lars Strojny <lstrojny@php.net>
 */
class Base64ValueTest extends \PHPUnit_Framework_TestCase
{
    public function testWithDecodedString()
    {
        $base64 = Base64Value::serialize('string');
        $this->assertSame('string', $base64->getDecoded());
        $this->assertSame('c3RyaW5n', $base64->getEncoded());
    }

    public function testWithEncodedString()
    {
        $base64 = Base64Value::deserialize('c3RyaW5n');
        $this->assertSame('string', $base64->getDecoded());
        $this->assertSame('c3RyaW5n', $base64->getEncoded());
    }

    public function testEncodedStringIsTrimmed()
    {
        $base64 = Base64Value::deserialize("\nc3RyaW5n   ");
        $this->assertSame('string', $base64->getDecoded());
        $this->assertSame('c3RyaW5n', $base64->getEncoded());
    }
}
