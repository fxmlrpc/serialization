<?php

namespace Fxmlrpc\Serialization\Exception;

/**
 * @author Lars Strojny <lstrojny@php.net>
 */
final class UnexpectedTagException extends SerializerException
{
    /**
     * @param string $tagName
     * @param mixed  $elements
     * @param array  $definedVariables
     * @param int    $depth
     * @param string $xml
     */
    public function __construct($tagName, $elements, array $definedVariables, $depth, $xml)
    {
        $expectedElements = [];
        foreach ($definedVariables as $variableName => $variable) {
            if (substr($variableName, 0, 4) !== 'flag') {
                continue;
            }

            if (($elements & $variable) === $variable) {
                $expectedElements[] = substr($variableName, 4);
            }
        }

        $this->message = sprintf(
            'Invalid XML. Expected one of "%s", got "%s" on depth %d (context: "%s")',
            implode('", "', $expectedElements),
            $tagName,
            $depth,
            $xml
        );
    }
}
