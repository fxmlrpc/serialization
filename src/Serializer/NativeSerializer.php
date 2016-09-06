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
        return xmlrpc_encode_request(
            $method,
            $this->convert($params),
            ['encoding' => 'UTF-8', 'escaping' => 'markup', 'verbosity' => 'no_white_space']
        );
    }

    /**
     * @param array $params
     *
     * @return array
     */
    private function convert(array $params)
    {
        foreach ($params as $key => $value) {
            $type = gettype($value);
            if ($type === 'array') {
                $params[$key] = $this->convert($value);
            } elseif ($type === 'object') {
                if ($value instanceof \DateTime) {
                    $params[$key] = (object) [
                        'xmlrpc_type' => 'datetime',
                        'scalar' => $value->format('Ymd\TH:i:s'),
                        'timestamp' => $value->format('u'),
                    ];
                } elseif ($value instanceof Base64) {
                    $params[$key] = (object) [
                        'xmlrpc_type' => 'base64',
                        'scalar' => $value->getDecoded(),
                    ];
                } else {
                    $params[$key] = get_object_vars($value);
                }
            } elseif ($type === 'resource') {
                throw new InvalidTypeException($value);
            }
        }

        return $params;
    }
}
