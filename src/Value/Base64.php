<?php

namespace Fxmlrpc\Serialization\Value;

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
