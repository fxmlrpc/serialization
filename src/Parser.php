<?php

namespace fXmlRpc\Serialization;

use fXmlRpc\Serialization\Exception\ParserException;

/**
 * Parser to parse XML responses into its PHP representation
 *
 * @author Lars Strojny <lstrojny@php.net>
 */
interface Parser
{
    /**
     * Parses XML string into PHP representation
     *
     * @param string  $xmlString
     * @param boolean $isFault
     *
     * @return mixed
     *
     * @throws ParserException
     */
    public function parse($xmlString, &$isFault);
}
