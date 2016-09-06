<?php

namespace spec\Fxmlrpc\Serialization;

use Fxmlrpc\Serialization\Exception\ParserException;
use Fxmlrpc\Serialization\XmlChecker;
use PhpSpec\ObjectBehavior;

class XmlCheckerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(XmlChecker::class);
    }

    function it_checks_valid_xml()
    {
        $this->isValid('<xml></xml>')->shouldReturn(true);
    }

    function it_throws_an_exception_when_xml_is_invalid()
    {
        $this->shouldThrow(ParserException::class)->duringIsValid('string');
    }
}
