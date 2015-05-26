<?php

/*
 * This file is part of the fXmlRpc Serialization package.
 *
 * (c) Lars Strojny <lstrojny@php.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace fXmlRpc\Serialization\Exception;

/**
 * @author Lars Strojny <lstrojny@php.net>
 */
final class ParserException extends \RuntimeException implements SerializationException
{
    /**
     * @param string  $tagName
     * @param mixed   $elements
     * @param array   $definedVariables
     * @param integer $depth
     * @param string  $xml
     *
     * @return self
     */
    public static function unexpectedTag($tagName, $elements, array $definedVariables, $depth, $xml)
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

        return new static(
            sprintf(
                'Invalid XML. Expected one of "%s", got "%s" on depth %d (context: "%s")',
                implode('", "', $expectedElements),
                $tagName,
                $depth,
                $xml
            )
        );
    }
}
