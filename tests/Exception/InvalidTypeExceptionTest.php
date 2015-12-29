<?php

namespace Fxmlrpc\Serialization\Tests\Exception;

use Fxmlrpc\Serialization\Exception\InvalidTypeException;

/**
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class InvalidTypeExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testIsInvalidTypeException()
    {
        $value = tmpfile();

        $e = new InvalidTypeException($value);

        $this->assertInstanceOf('fXmlRpc\Serialization\Exception\SerializerException', $e);

        $this->assertEquals(
            'Could not serialize resource of type "stream"',
            $e->getMessage()
        );
    }
}
