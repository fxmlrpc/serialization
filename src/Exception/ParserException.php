<?php

namespace Fxmlrpc\Serialization\Exception;

use Fxmlrpc\Serialization\Exception;

/**
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class ParserException extends \RuntimeException implements Exception
{
    /**
     * Named constructor for invalid XML values.
     *
     * @param string $string
     *
     * @return static
     */
    public static function notXml($string)
    {
        return new static(sprintf('Invalid XML. Expected XML, string given: "%s"', $string));
    }

    /**
     * @return static
     */
    public static function xmlrpcExtensionLibxmlParsehugeNotSupported()
    {
        return new static(
            'Parsing huge XML responses using libxml’s LIBXML_PARSEHUGE flag is not supported in ext/xmlrpc'
        );
    }
}
