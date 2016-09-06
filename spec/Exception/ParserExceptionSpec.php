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

    function it_creates_an_exception_when_string_is_not_xml()
    {
        $this->notXml('string')->shouldBeAnInstanceOf('Fxmlrpc\Serialization\Exception\ParserException');
    }

    function it_creates_an_exception_when_xml_is_too_big()
    {
        $this->xmlrpcExtensionLibxmlParsehugeNotSupported()->shouldBeAnInstanceOf('Fxmlrpc\Serialization\Exception\ParserException');
    }
}
