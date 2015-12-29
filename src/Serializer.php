<?php

namespace fXmlRpc\Serialization;

use fXmlRpc\Serialization\Exception\SerializerException;

/**
 * Serializer creates XML from native PHP types
 *
 * @author Lars Strojny <lstrojny@php.net>
 */
interface Serializer
{
    /**
     * Serializes XML/RPC method name and params into XML representation
     *
     * @param string $method
     * @param array  $params
     *
     * @return string
     *
     * @throws SerializerException
     */
    public function serialize($method, array $params = []);
}
