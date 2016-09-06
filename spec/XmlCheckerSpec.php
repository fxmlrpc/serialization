<?php

namespace spec\Fxmlrpc\Serialization;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class XmlCheckerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Fxmlrpc\Serialization\XmlChecker');
    }

    function it_checks_valid_xml()
    {
        $this->isValid('<xml></xml>')->shouldReturn(true);
    }

    function it_throws_an_exception_when_xml_is_invalid()
    {
        $this->shouldThrow('Fxmlrpc\Serialization\Exception\ParserException')->duringIsValid('string');
    }
}
