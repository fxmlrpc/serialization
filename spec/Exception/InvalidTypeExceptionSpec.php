<?php

namespace spec\Fxmlrpc\Serialization\Exception;

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
        $this->shouldHaveType('Fxmlrpc\Serialization\Exception\InvalidTypeException');
    }

    function it_is_a_serialization_exception()
    {
        $this->shouldImplement('Fxmlrpc\Serialization\Exception');
    }
}
