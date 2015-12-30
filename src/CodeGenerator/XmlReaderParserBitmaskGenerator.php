<?php

namespace Fxmlrpc\Serialization\CodeGenerator;

/**
 * Generates bitmasks for XmlReaderParser.
 *
 * @author Lars Strojny <lstrojny@php.net>
 */
final class XmlReaderParserBitmaskGenerator
{
    /**
     * @var array
     */
    private $basicTypes = [
        'methodResponse',
        'params',
        'fault',
        'param',
        'value',
        'array',
        'member',
        'name',
        '#text',
        'string',
        'struct',
        'int',
        'biginteger',
        'i8',
        'i4',
        'i2',
        'i1',
        'boolean',
        'double',
        'float',
        'bigdecimal',
        'dateTime.iso8601',
        'dateTime',
        'base64',
        'nil',
        'dom',
        'data',
    ];

    /**
     * @var array
     */
    private $combinedTypes = [];

    /**
     * @var int
     */
    private $typeCount = 0;

    /**
     * @var array
     */
    private $values = [];

    public function __construct()
    {
        $this->combinedTypes = [
            'expectedForMethodResponse' => ['params', 'fault'],
            'expectedForMember' => ['name', 'value'],
            'expectedForSimpleType' => ['#text', 'value'],
            'expectedForNil' => ['nil', 'value'],
            'expectedForValue' => [
                'string',
                'array',
                'struct',
                'int',
                'biginteger',
                'i8',
                'i4',
                'i2',
                'i1',
                'boolean',
                'double',
                'float',
                'bigdecimal',
                'dateTime.iso8601',
                'dateTime',
                'base64',
                'nil',
                'dom',
                '#text',
                'value',
            ],
            'expectedForStruct' => ['member', 'struct', 'value'],
            'expectedForData' => ['data', 'value', 'array'],
            'expectedAfterValue' => [
                'param',
                'value',
                'data',
                'member',
                'name',
                'int',
                'i4',
                'i2',
                'i1',
                'base64',
                'fault',
            ],
            'expectedAfterParam' => ['param', 'params'],
            'expectedAfterName' => ['value', 'member'],
            'expectedAfterMember' => ['struct', 'member'],
            'allFlags' => $this->basicTypes,
        ];

        $this->typeCount = count($this->basicTypes);
    }

    private function createBitmaskVariable($type, $bitmask, $prefix = '')
    {
        $variableName = preg_match('/^\w+[\d\w_]*$/', $type)
            ? 'static $'.$prefix.$type
            : '${\''.$prefix.$type.'\'}';
        $this->values[$type] = $bitmask;

        return $variableName.' = 0b'.sprintf('%0'.$this->typeCount.'b', $this->values[$type]).';';
    }

    public function generate()
    {
        $code = [];
        $bitmask = 1;
        foreach ($this->basicTypes as $type) {
            $code[] = $this->createBitmaskVariable($type, $bitmask, 'flag');
            $bitmask = $bitmask << 1;
        }

        foreach ($this->combinedTypes as $type => $combination) {
            $value = 0;
            foreach ($combination as $subType) {
                $value |= $this->values[$subType];
            }
            $code[] = $this->createBitmaskVariable($type, $value);
        }

        $commentStart = <<<'EOS'
// This following assignments are auto-generated using %s
// Don’t edit manually
EOS;

        $commentStart = sprintf($commentStart, __CLASS__);

        $commentEnd = '// End of auto-generated code';

        return $commentStart."\n".implode("\n", $code)."\n".$commentEnd;
    }
}
