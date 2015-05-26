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

use fXmlRpc\Serialization\Exception\InvalidTypeException;

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
