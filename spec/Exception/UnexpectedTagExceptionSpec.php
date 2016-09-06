<?php

namespace spec\Fxmlrpc\Serialization\Exception;

use Fxmlrpc\Serialization\Exception;
use Fxmlrpc\Serialization\Exception\UnexpectedTagException;
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
        $this->shouldHaveType(UnexpectedTagException::class);
    }

    function it_is_a_serialization_exception()
    {
        $this->shouldImplement(Exception::class);
    }

    function it_has_a_message()
    {
        $this->getMessage()->shouldReturn('Invalid XML. Expected one of "Test", "Another", got "invalid" on depth 5 (context: "<tag><invalid></invalid></tag>")');
    }
}
