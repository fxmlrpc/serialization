<?php

namespace spec\Fxmlrpc\Serialization\Exception;

use Fxmlrpc\Serialization\Exception;
use Fxmlrpc\Serialization\Exception\ParserException;
use PhpSpec\ObjectBehavior;

class ParserExceptionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ParserException::class);
    }

    function it_is_a_serialization_exception()
    {
        $this->shouldImplement(Exception::class);
    }

    function it_creates_an_exception_when_string_is_not_xml()
    {
        $this->notXml('string')->shouldBeAnInstanceOf(ParserException::class);
    }

    function it_creates_an_exception_when_xml_is_too_big()
    {
        $this->xmlrpcExtensionLibxmlParsehugeNotSupported()->shouldBeAnInstanceOf(ParserException::class);
    }
}
