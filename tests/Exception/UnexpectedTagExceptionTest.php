<?php

namespace Fxmlrpc\Serialization\Tests\Exception;

use Fxmlrpc\Serialization\Exception\UnexpectedTagException;

/**
 * @author Lars Strojny <lstrojny@php.net>
 */
class UnexpectedTagExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testHasUnexpectedTagConstructor()
    {
        $e = new UnexpectedTagException(
            'invalid',
            'val',
            [
                'flagTest'          => 'val',
                'flagAnother'       => 'val',
                'thisWIllBeSkipped' => 'val',
            ],
            5,
            '<tag><invalid></invalid></tag>'
        );

        $this->assertInstanceOf('Fxmlrpc\Serialization\Exception\SerializerException', $e);

        $this->assertEquals(
            'Invalid XML. Expected one of "Test", "Another", got "invalid" on depth 5 (context: "<tag><invalid></invalid></tag>")',
            $e->getMessage()
        );
    }
}
