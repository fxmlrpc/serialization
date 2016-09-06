<?php

namespace spec\Fxmlrpc\Serialization\Exception;

use Fxmlrpc\Serialization\Exception;
use Fxmlrpc\Serialization\Exception\SerializerException;
use PhpSpec\ObjectBehavior;

class SerializerExceptionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(SerializerException::class);
    }

    function it_is_a_serialization_exception()
    {
        $this->shouldImplement(Exception::class);
    }
}
