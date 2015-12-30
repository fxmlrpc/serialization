<?php

namespace Fxmlrpc\Serialization\Tests\Serializer;

use Fxmlrpc\Serialization\Serializer\NativeSerializer;
use Fxmlrpc\Serialization\Tests\SerializerTestCase;

/**
 * @author Lars Strojny <lstrojny@php.net>
 */
class NativeSerializerTest extends SerializerTestCase
{
    public function setUp()
    {
        $this->serializer = new NativeSerializer();
    }
}
