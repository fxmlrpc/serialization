<?php

namespace Fxmlrpc\Benchmark;

use Fxmlrpc\Serialization\Serializer\NativeSerializer;
use Fxmlrpc\Serialization\Serializer\XmlWriterSerializer;
use Fxmlrpc\Serialization\Serializer\Zend1Serializer;
use Fxmlrpc\Serialization\Serializer\Zend2Serializer;
use Fxmlrpc\Serialization\Value\Base64Value;
use PhpBench\Benchmark\Metadata\Annotations\Iterations;
use PhpBench\Benchmark\Metadata\Annotations\ParamProviders;
use PhpBench\Benchmark\Metadata\Annotations\Revs;

/**
 * Compares serializer implementations.
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 *
 * @Iterations(10)
 * @Revs(4)
 */
class SerializerBench
{
    public function paramProvider()
    {
        return [
            [
                'test_string' => [4 => str_repeat('aä', 1000000)],
                'test_integer' => (int) rand(),
                'test_float' => (float) rand(),
                'test_datetime' => new \DateTime(),
                'test_base64' => Base64Value::serialize(str_repeat('a', 100000)),
            ]
        ];
    }

    /**
     * @ParamProviders({"paramProvider"})
     */
    public function benchNativeSerializer($params)
    {
        $serializer = new NativeSerializer();

        $serializer->serialize('test', $params);
    }

    /**
     * @ParamProviders({"paramProvider"})
     */
    public function benchSaxSerializer($params)
    {
        $serializer = new XmlWriterSerializer();

        $serializer->serialize('test', $params);
    }

    /**
     * @ParamProviders({"paramProvider"})
     */
    public function benchZend1Serializer($params)
    {
        $serializer = new Zend1Serializer();

        $serializer->serialize('test', $params);
    }

    /**
     * @ParamProviders({"paramProvider"})
     */
    public function benchZend2Serializer($params)
    {
        $serializer = new Zend2Serializer();

        $serializer->serialize('test', $params);
    }
}
