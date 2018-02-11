<?php

namespace Fxmlrpc\Serialization\Parser;

use Fxmlrpc\Serialization\Exception\FaultException;
use Fxmlrpc\Serialization\Exception\ParserException;
use Fxmlrpc\Serialization\Parser;
use Fxmlrpc\Serialization\Value\Base64Value;
use Fxmlrpc\Serialization\XmlChecker;

/**
 * Parser to parse XML responses into its PHP representation using XML RPC extension.
 *
 * @author Lars Strojny <lstrojny@php.net>
 */
final class NativeParser implements Parser
{
    const LIBXML_PARSEHUGE_THRESHOLD = 1024 * 1024 * 10;

    /**
     * @var bool
     */
    private $validateResponse;

    /**
     * @param bool $validateResponse
     */
    public function __construct($validateResponse = true)
    {
        $this->validateResponse = $validateResponse;
    }

    /**
     * Check whether a given string is over the parse limit.
     *
     * @param string $xmlString
     *
     * @return bool
     */
    public static function isBiggerThanParseLimit($xmlString)
    {
        return strlen($xmlString) > static::LIBXML_PARSEHUGE_THRESHOLD;
    }

    /**
     * {@inheritdoc}
     */
    public function parse($xmlString)
    {
        if ($this->validateResponse) {
            XmlChecker::isValid($xmlString);
        }

        $result = xmlrpc_decode($xmlString, 'UTF-8');

        if (null === $result && self::isBiggerThanParseLimit($xmlString)) {
            throw ParserException::xmlrpcExtensionLibxmlParsehugeNotSupported();
        }

        $toBeVisited = [&$result];
        while (isset($toBeVisited[0]) && $value = &$toBeVisited[0]) {
            $type = gettype($value);
            if ('object' === $type) {
                $xmlRpcType = $value->{'xmlrpc_type'};
                if ('datetime' === $xmlRpcType) {
                    $value = \DateTime::createFromFormat(
                        'Ymd\TH:i:s',
                        $value->scalar,
                        isset($timezone) ? $timezone : $timezone = new \DateTimeZone('UTC')
                    );
                } elseif ('base64' === $xmlRpcType) {
                    if ('' !== $value->scalar) {
                        $value = Base64Value::serialize($value->scalar);
                    } else {
                        $value = null;
                    }
                }
            } elseif ('array' === $type) {
                foreach ($value as &$element) {
                    $toBeVisited[] = &$element;
                }
            }

            array_shift($toBeVisited);
        }

        if (is_array($result)) {
            reset($result);

            if (xmlrpc_is_fault($result)) {
                throw FaultException::createFromResponse($result);
            }
        }

        return $result;
    }
}
