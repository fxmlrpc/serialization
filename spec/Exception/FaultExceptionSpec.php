<?php

namespace spec\Fxmlrpc\Serialization\Exception;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FaultExceptionSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('Fault', 1);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Fxmlrpc\Serialization\Exception\FaultException');
    }

    function it_is_a_serialization_exception()
    {
        $this->shouldImplement('Fxmlrpc\Serialization\Exception');
    }

    function it_has_a_fault_string()
    {
        $this->getMessage()->shouldReturn('Fault');
    }

    function it_has_a_fault_code()
    {
        $this->getCode()->shouldReturn(1);
    }

    function it_creates_an_exception_from_response()
    {
        $response = [
            'faultString' => 'Fault',
            'faultCode' => 1,
        ];

        $e = $this->createFromResponse($response);

        $e->getMessage()->shouldReturn('Fault');
        $e->getCode()->shouldReturn(1);
    }

    function it_creates_an_exception_from_empty_response()
    {
        $response = [];

        $e = $this->createFromResponse($response);

        $e->getMessage()->shouldReturn('Unknown');
        $e->getCode()->shouldReturn(0);
    }
}
