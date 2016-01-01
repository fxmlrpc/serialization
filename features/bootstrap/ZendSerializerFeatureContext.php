<?php

use Behat\Behat\Context\Context;

/**
 * Defines serializer features from the specific context.
 */
class ZendSerializerFeatureContext implements Context
{
    use SerializerContext;

    /**
     * @param string $serializerClass
     */
    public function __construct($serializerClass)
    {
        $this->serializer = new $serializerClass();
    }
}
