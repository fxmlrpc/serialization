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
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
final class InvalidTypeException extends \RuntimeException implements SerializerException
{
    /**
     * @param mixed $value
     */
    public function __construct($value)
    {
        $this->message = sprintf('Could not serialize %s of type "%s"', gettype($value), get_resource_type($value));
    }
}
