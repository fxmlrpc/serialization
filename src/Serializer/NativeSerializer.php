<?php

namespace Fxmlrpc\Serialization\Serializer;

use Fxmlrpc\Serialization\Exception\InvalidTypeException;
use Fxmlrpc\Serialization\Serializer;
use Fxmlrpc\Serialization\Value\Base64;

/**
 * Serializer creates XML from native PHP types using XML RPC extension.
 *
 * @author Lars Strojny <lstrojny@php.net>
 */
final class NativeSerializer implements Serializer
{
    /**
     * {@inheritdoc}
     */
    public function serialize($method, array $params = [])
    {
        $toBeVisited = [&$params];

        while (isset($toBeVisited[0]) && $value = &$toBeVisited[0]) {
            $type = gettype($value);

            if ($type === 'array') {
                foreach ($value as &$child) {
                    $toBeVisited[] = &$child;
                }
            } elseif ($type === 'object') {
                if ($value instanceof \DateTime) {
                    $value = $value->format('Ymd\TH:i:s');
                    xmlrpc_set_type($value, 'datetime');
                } elseif ($value instanceof Base64) {
                    $value = $value->getDecoded();
                    xmlrpc_set_type($value, 'base64');
                } else {
                    $value = get_object_vars($value);
                }
            } elseif ($type === 'resource') {
                throw new InvalidTypeException($value);
            }

            array_shift($toBeVisited);
        }

        return xmlrpc_encode_request(
            $method,
            $params,
            ['encoding' => 'UTF-8', 'escaping' => 'markup', 'verbosity' => 'no_white_space']
        );
    }
}
