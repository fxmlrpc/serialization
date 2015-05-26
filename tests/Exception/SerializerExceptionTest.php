<?php

/*
 * This file is part of the fXmlRpc Serialization package.
 *
 * (c) Lars Strojny <lstrojny@php.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace fXmlRpc\Serialization\Tests\Exception;

use fXmlRpc\Serialization\Exception\SerializerException;

/**
 * @author Lars Strojny <lstrojny@php.net>
 */
class SerializerExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testExceptionImplementsSerializationExceptionInterface()
    {
        $this->assertInstanceOf('fXmlRpc\Serialization\Exception\SerializationException', new SerializerException());
    }

    public function testHasInvalidTypeConstructor()
    {
        $value = tmpfile();

        $e = SerializerException::invalidType($value);

        $this->assertEquals(
            'Could not serialize resource of type "stream"',
            $e->getMessage()
        );
    }
}
