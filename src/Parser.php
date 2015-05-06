<?php

/*
 * This file is part of the fXmlRpc Serialization package.
 *
 * (c) Lars Strojny <lstrojny@php.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
