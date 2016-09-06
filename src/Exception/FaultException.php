<?php

namespace Fxmlrpc\Serialization\Exception;

use Fxmlrpc\Serialization\Exception;

/**
 * Thrown when the response is a fault.
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
final class FaultException extends \RuntimeException implements Exception
{
    /**
     * @param string $faultString
     * @param int    $faultCode
     */
    public function __construct($faultString, $faultCode)
    {
        parent::__construct($faultString, $faultCode);
    }

    /**
     * Creates a FaultException from XML-RPC response.
     *
     * @param array $response
     *
     * @return FaultException
     */
    public static function createFromResponse(array $response)
    {
        $faultString = isset($response['faultString']) ? $response['faultString'] : 'Unknown';
        $faultCode = isset($response['faultCode']) ? $response['faultCode'] : 0;

        return new self($faultString, $faultCode);
    }
}
