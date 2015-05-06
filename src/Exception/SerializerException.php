<?php

/*
 * This file is part of the fXmlRpc Serialization package.
 *
 * (c) Lars Strojny <lstrojny@php.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace fXmlRpc\Serialization\Exception;

/**
 * @author Lars Strojny <lstrojny@php.net>
 */
final class SerializerException extends \RuntimeException implements SerializationException
{
    /**
     * @param mixed $value
     *
     * @return self
     */
    public static function invalidType($value)
    {
        return new static(sprintf('Could not serialize %s of type "%s"', gettype($value), get_resource_type($value)));
    }
}
