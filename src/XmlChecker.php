<?php

namespace Fxmlrpc\Serialization;

use Fxmlrpc\Serialization\Exception\ParserException;

/**
 * Class XmlChecker to check is correct XML.
 *
 * @author Piotr Olaszewski <piotroo89@gmail.com>
 */
final class XmlChecker
{
    /**
     * @param string $xml
     *
     * @return bool
     *
     * @throws ParserException
     */
    public static function isValid($xml)
    {
        $useErrors = libxml_use_internal_errors(true);

        $isCorrect = simplexml_load_string($xml);

        libxml_use_internal_errors($useErrors);

        if (false === $isCorrect) {
            throw ParserException::notXml($xml);
        }

        return true;
    }
}
