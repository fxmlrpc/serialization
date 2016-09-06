<?php

namespace spec\Fxmlrpc\Serialization\Exception;

use Fxmlrpc\Serialization\Exception;
use Fxmlrpc\Serialization\Exception\FaultException;
use PhpSpec\ObjectBehavior;

class FaultExceptionSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('Fault', 1);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(FaultException::class);
    }

    function it_is_a_serialization_exception()
    {
        $this->shouldImplement(Exception::class);
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
