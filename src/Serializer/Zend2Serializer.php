<?php

namespace Fxmlrpc\Serialization\Serializer;

use Fxmlrpc\Serialization\Exception\InvalidTypeException;
use Fxmlrpc\Serialization\Exception\SerializerException;
use Fxmlrpc\Serialization\Serializer;
use Fxmlrpc\Serialization\Value\Base64;
use Zend\XmlRpc\AbstractValue;
use Zend\XmlRpc\Request;

/**
 * Serializer creates XML from native PHP types using XML RPC extension.
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
final class Zend2Serializer implements Serializer
{
    /**
     * {@inheritdoc}
     */
    public function serialize($method, array $params = [])
    {
        $toBeVisited = [&$params];

        while (isset($toBeVisited[0]) && $value = &$toBeVisited[0]) {
            $type = gettype($value);

            if ('array' === $type) {
                // Zend converts non-zero-indexed arrays to structs
                if ((array_keys($value) !== range(0, count($value) - 1)) && (array_keys($value) == range(1, count($value)))) {
                    $value = array_values($value);
                }

                foreach ($value as &$child) {
                    $toBeVisited[] = &$child;
                }
            } elseif ('object' === $type) {
                if ($value instanceof \DateTime) {
                    $value = AbstractValue::getXmlRpcValue($value->format('Ymd\TH:i:s'), AbstractValue::XMLRPC_TYPE_DATETIME);
                } elseif ($value instanceof Base64) {
                    $value = AbstractValue::getXmlRpcValue($value->getDecoded(), AbstractValue::XMLRPC_TYPE_BASE64);
                } else {
                    $value = get_object_vars($value);
                }
            } elseif ('resource' === $type) {
                throw new InvalidTypeException($value);
            }

            array_shift($toBeVisited);
        }

        $request = new Request($method, $params);

        try {
            return $request->saveXml();
        } catch (\Exception $e) {
            throw new SerializerException($e->getMessage(), $e->getCode(), $e);
        }
    }
}
