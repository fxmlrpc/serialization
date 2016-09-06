<?php

namespace spec\Fxmlrpc\Serialization\Exception;

use Fxmlrpc\Serialization\Exception;
use Fxmlrpc\Serialization\Exception\InvalidTypeException;
use PhpSpec\ObjectBehavior;

class InvalidTypeExceptionSpec extends ObjectBehavior
{
    function let()
    {
        // TODO: replace this wih mocking or other better solution
        $value = tmpfile();

        $this->beConstructedWith($value);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(InvalidTypeException::class);
    }

    function it_is_a_serialization_exception()
    {
        $this->shouldImplement(Exception::class);
    }
}
