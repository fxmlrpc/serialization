<?php

namespace spec\Fxmlrpc\Serialization\CodeGenerator;

use Fxmlrpc\Serialization\CodeGenerator\XmlReaderParserBitmaskGenerator;
use PhpSpec\ObjectBehavior;

class XmlReaderParserBitmaskGeneratorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(XmlReaderParserBitmaskGenerator::class);
    }

    function it_generates_bitmask()
    {
        $code = <<<'EOS'
// This following assignments are auto-generated using Fxmlrpc\Serialization\CodeGenerator\XmlReaderParserBitmaskGenerator
// Don’t edit manually
static $flagmethodResponse = 0b000000000000000000000000001;
static $flagparams = 0b000000000000000000000000010;
static $flagfault = 0b000000000000000000000000100;
static $flagparam = 0b000000000000000000000001000;
static $flagvalue = 0b000000000000000000000010000;
static $flagarray = 0b000000000000000000000100000;
static $flagmember = 0b000000000000000000001000000;
static $flagname = 0b000000000000000000010000000;
${'flag#text'} = 0b000000000000000000100000000;
static $flagstring = 0b000000000000000001000000000;
static $flagstruct = 0b000000000000000010000000000;
static $flagint = 0b000000000000000100000000000;
static $flagbiginteger = 0b000000000000001000000000000;
static $flagi8 = 0b000000000000010000000000000;
static $flagi4 = 0b000000000000100000000000000;
static $flagi2 = 0b000000000001000000000000000;
static $flagi1 = 0b000000000010000000000000000;
static $flagboolean = 0b000000000100000000000000000;
static $flagdouble = 0b000000001000000000000000000;
static $flagfloat = 0b000000010000000000000000000;
static $flagbigdecimal = 0b000000100000000000000000000;
${'flagdateTime.iso8601'} = 0b000001000000000000000000000;
static $flagdateTime = 0b000010000000000000000000000;
static $flagbase64 = 0b000100000000000000000000000;
static $flagnil = 0b001000000000000000000000000;
static $flagdom = 0b010000000000000000000000000;
static $flagdata = 0b100000000000000000000000000;
static $expectedForMethodResponse = 0b000000000000000000000000110;
static $expectedForMember = 0b000000000000000000010010000;
static $expectedForSimpleType = 0b000000000000000000100010000;
static $expectedForNil = 0b001000000000000000000010000;
static $expectedForValue = 0b011111111111111111100110000;
static $expectedForStruct = 0b000000000000000010001010000;
static $expectedForData = 0b100000000000000000000110000;
static $expectedAfterValue = 0b100100000011100100011011100;
static $expectedAfterParam = 0b000000000000000000000001010;
static $expectedAfterName = 0b000000000000000000001010000;
static $expectedAfterMember = 0b000000000000000010001000000;
static $allFlags = 0b111111111111111111111111111;
// End of auto-generated code
EOS;

        $this->generate()->shouldReturn($code);
    }
}
