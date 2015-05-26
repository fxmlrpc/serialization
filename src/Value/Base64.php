<?php

/*
 * This file is part of the fXmlRpc Serialization package.
 *
 * (c) Lars Strojny <lstrojny@php.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace fXmlRpc\Serialization\Value;

/**
 * Value object representing Base64-encoded and raw string value
 *
 * @author Lars Strojny <lstrojny@php.net>
 */
interface Base64
{
    /**
     * Returns base64 value as base64 encoded string
     *
     * @return string
     */
    public function getEncoded();

    /**
     * Returns base64 value as binary string
     *
     * @return string
     */
    public function getDecoded();
}
