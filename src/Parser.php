<?php

namespace Fxmlrpc\Serialization;

use Fxmlrpc\Serialization\Exception\ParserException;

/**
 * Parser to parse XML responses into its PHP representation.
 *
 * @author Lars Strojny <lstrojny@php.net>
 */
interface Parser
{
    /**
     * Parses XML string into PHP representation.
     *
     * @param string $xmlString
     * @param bool   $isFault
     *
     * @return mixed
     *
     * @throws ParserException
     */
    public function parse($xmlString, &$isFault);
}
