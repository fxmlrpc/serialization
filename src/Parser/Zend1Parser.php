<?php

namespace Fxmlrpc\Serialization\Parser;

use Fxmlrpc\Serialization\Exception\FaultException;
use Fxmlrpc\Serialization\Exception\ParserException;
use Fxmlrpc\Serialization\Parser;

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
    public function parse($xmlString)
    {
        $response = new \Zend_XmlRpc_Response();

        try {
            $response->loadXml($xmlString);
        } catch (\Exception $e) {
            throw new ParserException($e->getMessage(), $e->getCode(), $e);
        }

        if ($response->isFault()) {
            $fault = $response->getFault();

            throw new FaultException($fault->getMessage(), $fault->getCode());
        }

        $result = $response->getReturnValue();

        $toBeVisited = [&$result];

        while (isset($toBeVisited[0]) && $value = &$toBeVisited[0]) {
            $type = gettype($value);
            if ('array' === $type) {
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
