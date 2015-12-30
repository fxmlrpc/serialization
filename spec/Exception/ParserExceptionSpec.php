<?php

namespace spec\Fxmlrpc\Serialization\Exception;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ParserExceptionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Fxmlrpc\Serialization\Exception\ParserException');
    }

    function it_is_a_serialization_exception()
    {
        $this->shouldImplement('Fxmlrpc\Serialization\Exception');
    }
}
