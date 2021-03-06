<?php

namespace Fxmlrpc\Benchmark;

use Fxmlrpc\Serialization\Parser;
use Fxmlrpc\Serialization\Parser\NativeParser;
use Fxmlrpc\Serialization\Parser\XmlReaderParser;
use Fxmlrpc\Serialization\Parser\ZendParser;
use PhpBench\Benchmark\Metadata\Annotations\Iterations;
use PhpBench\Benchmark\Metadata\Annotations\ParamProviders;
use PhpBench\Benchmark\Metadata\Annotations\Revs;

/**
 * Compares parser implementations.
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 *
 * @Iterations(10)
 * @Revs(4)
 */
class ParserBench
{
    public function xmlProvider()
    {
        return [
            [file_get_contents(__DIR__.'/../fixtures/response.xml')],
        ];
    }

    /**
     * @ParamProviders({"xmlProvider"})
     */
    public function benchNativeParser($xml)
    {
        $parser = new NativeParser();

        $parser->parse($xml[0]);
    }

    /**
     * @ParamProviders({"xmlProvider"})
     */
    public function benchSaxParser($xml)
    {
        $parser = new XmlReaderParser();

        $parser->parse($xml[0]);
    }

    /**
     * @ParamProviders({"xmlProvider"})
     */
    public function benchZendParser($xml)
    {
        $parser = new ZendParser();

        $parser->parse($xml[0]);
    }
}
