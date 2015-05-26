<?php

namespace spec\fXmlRpc\Serialization\Exception;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class InvalidTypeExceptionSpec extends ObjectBehavior
{
    function let()
    {
        $value = tmpfile();

        $this->beConstructedWith($value);
    }

    function it_is_initializable()
    {
        /**
         * Ugly hack
         *
         * @see https://github.com/phpspec/phpspec/issues/704
         */
        $this->getWrappedObject();

        $this->shouldHaveType('fXmlRpc\Serialization\Exception\InvalidTypeException');
    }

    function it_is_a_serializer_exception()
    {
        /**
         * Ugly hack
         *
         * @see https://github.com/phpspec/phpspec/issues/704
         */
        $this->getWrappedObject();

        $this->shouldImplement('fXmlRpc\Serialization\Exception\SerializerException');
    }

    function it_has_a_message()
    {
        $this->getMessage()->shouldReturn('Could not serialize resource of type "stream"');
    }
}
