<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;

/**
 * Defines serializer features from the specific context.
 */
class ZendSerializerFeatureContext implements Context, SnippetAcceptingContext
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
