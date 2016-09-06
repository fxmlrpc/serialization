<?php

namespace spec\Fxmlrpc\Serialization\Value;

use Fxmlrpc\Serialization\Value\Base64;
use Fxmlrpc\Serialization\Value\Base64Value;
use PhpSpec\ObjectBehavior;

class Base64ValueSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(null, null);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Base64Value::class);
    }

    function it_is_a_base64_value()
    {
        $this->shouldImplement(Base64::class);
    }

    function it_encodes_a_string()
    {
        $this->beConstructedWith(null, 'string');

        $this->getEncoded()->shouldReturn(base64_encode('string'));
        $this->getDecoded()->shouldReturn('string');
    }

    function it_serializes_a_string()
    {
        $base64 = $this->serialize('string');

        $base64->getEncoded()->shouldReturn(base64_encode('string'));
        $base64->getDecoded()->shouldReturn('string');
    }

    function it_decodes_a_string()
    {
        $this->beConstructedWith(base64_encode('string'), null);

        $this->getEncoded()->shouldReturn(base64_encode('string'));
        $this->getDecoded()->shouldReturn('string');
    }

    function it_deserializes_a_string()
    {
        $base64 = $this->deserialize(base64_encode('string'));

        $base64->getEncoded()->shouldReturn(base64_encode('string'));
        $base64->getDecoded()->shouldReturn('string');
    }

    function it_trims_an_encoded_value()
    {
        $base64 = $this->deserialize(sprintf("\n%s     ", base64_encode('string')));

        $base64->getEncoded()->shouldReturn(base64_encode('string'));
        $base64->getDecoded()->shouldReturn('string');
    }
}
