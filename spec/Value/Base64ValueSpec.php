<?php

namespace spec\fXmlRpc\Serialization\Value;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class Base64ValueSpec extends ObjectBehavior
{
    protected $value = 'value';

    function let()
    {
        $this->beConstructedWith(null, null);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('fXmlRpc\Serialization\Value\Base64Value');
    }

    function it_is_base64()
    {
        $this->shouldHaveType('fXmlRpc\Serialization\Value\Base64');
    }

    function it_encodes_an_decoded_string()
    {
        $this->beConstructedWith(null, $this->value);

        $this->getEncoded()->shouldReturn(base64_encode($this->value));
        $this->getDecoded()->shouldReturn($this->value);
    }

    function it_decodes_an_encoded_string()
    {
        $this->beConstructedWith(base64_encode($this->value), null);

        $this->getEncoded()->shouldReturn(base64_encode($this->value));
        $this->getDecoded()->shouldReturn($this->value);
    }

    function it_serializes_a_decoded_string()
    {
        $base64 = $this->serialize($this->value);

        $base64->shouldHaveType('fXmlRpc\Serialization\Value\Base64Value');

        $base64->getEncoded()->shouldReturn(base64_encode($this->value));
        $base64->getDecoded()->shouldReturn($this->value);
    }

    function it_deserializes_an_encoded_string()
    {
        $base64 = $this->deserialize(base64_encode($this->value));

        $base64->shouldHaveType('fXmlRpc\Serialization\Value\Base64Value');

        $base64->getEncoded()->shouldReturn(base64_encode($this->value));
        $base64->getDecoded()->shouldReturn($this->value);
    }

    function it_deserializes_and_trims_an_encoded_string()
    {
        $base64 = $this->deserialize(sprintf("\n%s   ", base64_encode($this->value)));

        $base64->shouldHaveType('fXmlRpc\Serialization\Value\Base64Value');

        $base64->getEncoded()->shouldReturn(base64_encode($this->value));
        $base64->getDecoded()->shouldReturn($this->value);
    }
}
