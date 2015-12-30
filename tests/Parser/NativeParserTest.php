<?php

namespace Fxmlrpc\Serialization\Tests\Parser;

use Fxmlrpc\Serialization\Parser\NativeParser;
use Fxmlrpc\Serialization\Tests\ParserTestCase;

/**
 * @author Lars Strojny <lstrojny@php.net>
 */
class NativeParserTest extends ParserTestCase
{
    public function setUp()
    {
        $this->parser = new NativeParser();
    }
}
