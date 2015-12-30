<?php

namespace Fxmlrpc\Serialization\Serializer;

use Fxmlrpc\Serialization\Exception\InvalidTypeException;
use Fxmlrpc\Serialization\Exception\SerializerException;
use Fxmlrpc\Serialization\Serializer;
use Fxmlrpc\Serialization\Value\Base64;

/**
 * Serializer creates XML from native PHP types using XML RPC extension.
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
final class Zend1Serializer implements Serializer
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
                // Zend converts non-zero-indexed arrays to structs
                if ((array_keys($value) !== range(0, count($value) - 1)) && (array_keys($value) == range(1, count($value)))) {
                    $value = array_values($value);
                }

                foreach ($value as &$child) {
                    $toBeVisited[] = &$child;
                }
            } elseif ($type === 'object') {
                if ($value instanceof \DateTime) {
                    $value = \Zend_XmlRpc_Value::getXmlRpcValue($value->format('Ymd\TH:i:s'), \Zend_XmlRpc_Value::XMLRPC_TYPE_DATETIME);
                } elseif ($value instanceof Base64) {
                    $value = \Zend_XmlRpc_Value::getXmlRpcValue($value->getDecoded(), \Zend_XmlRpc_Value::XMLRPC_TYPE_BASE64);
                } else {
                    $value = get_object_vars($value);
                }
            } elseif ($type === 'resource') {
                throw new InvalidTypeException($value);
            }

            array_shift($toBeVisited);
        }

        $request = new \Zend_XmlRpc_Request($method, $params);

        try {
            return $request->saveXml();
        } catch (\Exception $e) {
            throw new SerializerException($e->getMessage(), $e->getCode(), $e);
        }
    }
}
