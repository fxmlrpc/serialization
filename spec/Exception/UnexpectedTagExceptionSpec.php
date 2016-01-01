<?php

namespace spec\Fxmlrpc\Serialization\Exception;

use PhpSpec\ObjectBehavior;

class UnexpectedTagExceptionSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(
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
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Fxmlrpc\Serialization\Exception\UnexpectedTagException');
    }

    function it_is_a_serialization_exception()
    {
        $this->shouldImplement('Fxmlrpc\Serialization\Exception');
    }

    function it_has_a_message()
    {
        $this->getMessage()->shouldReturn('Invalid XML. Expected one of "Test", "Another", got "invalid" on depth 5 (context: "<tag><invalid></invalid></tag>")');
    }
}
