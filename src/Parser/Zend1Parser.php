<?php

namespace Fxmlrpc\Serialization\Parser;

use Fxmlrpc\Serialization\Exception\ParserException;
use Fxmlrpc\Serialization\Parser;
use Fxmlrpc\Serialization\Value\Base64Value;

/**
 * Parser to parse XML responses into its PHP representation using XML RPC extension.
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
final class Zend1Parser implements Parser
{
    /**
     * {@inheritdoc}
     */
    public function parse($xmlString, &$isFault)
    {
        $response = new \Zend_XmlRpc_Response();

        try {
            $response->loadXml($xmlString);
        } catch (\Exception $e) {
            throw new ParserException($e->getMessage(), $e->getCode(), $e);
        }

        $isFault = $response->isFault();

        if ($isFault) {
            $fault = $response->getFault();

            return [
                'faultCode'   => $fault->getCode(),
                'faultString' => $fault->getMessage(),
            ];
        }

        $result = $response->getReturnValue();

        $toBeVisited = [&$result];

        while (isset($toBeVisited[0]) && $value = &$toBeVisited[0]) {
            $type = gettype($value);
            if ($type === 'array') {
                foreach ($value as &$element) {
                    $toBeVisited[] = &$element;
                }

                reset($value); // Reset all array pointers
            }

            array_shift($toBeVisited);
        }

        return $result;
    }
}
