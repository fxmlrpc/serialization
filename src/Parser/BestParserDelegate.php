<?php

namespace Fxmlrpc\Serialization\Parser;

use Fxmlrpc\Serialization\Parser;

/**
 * Parser that selects the best available parser.
 *
 * @author Lars Strojny <lstrojny@php.net>
 */
final class BestParserDelegate implements Parser
{
    /**
     * @var NativeParser
     */
    private $nativeParser;

    /**
     * @var XmlReaderParser
     */
    private $xmlReaderParser;

    /**
     * @param bool $validateResponse
     */
    public function __construct($validateResponse = true)
    {
        $this->nativeParser = new NativeParser($validateResponse);
        $this->xmlReaderParser = new XmlReaderParser($validateResponse);
    }

    /**
     * {@inheritdoc}
     */
    public function parse($xmlString)
    {
        return !NativeParser::isBiggerThanParseLimit($xmlString)
            ? $this->nativeParser->parse($xmlString)
            : $this->xmlReaderParser->parse($xmlString);
    }
}
