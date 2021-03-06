<?php

namespace Fxmlrpc\Serialization\Exception;

/**
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
final class InvalidTypeException extends SerializerException
{
    /**
     * @param mixed $value
     */
    public function __construct($value)
    {
        $this->message = sprintf('Could not serialize %s of type "%s"', gettype($value), get_resource_type($value));
    }
}
