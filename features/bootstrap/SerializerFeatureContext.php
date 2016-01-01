<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;

/**
 * Defines serializer features from the specific context.
 */
class SerializerFeatureContext implements Context, SnippetAcceptingContext
{
    use SerializerContext {
        iShouldSeeARequestWithTheParameterOfType as protected iShouldSeeARequestWithTheParameterOfTypeOrig;
    }

    /**
     * @param string $serializerClass
     */
    public function __construct($serializerClass)
    {
        $this->serializer = new $serializerClass();
    }

    /**
     * XMLRPC extension adds newlines.
     *
     * @see http://php.net/manual/en/function.xmlrpc-encode-request.php#27992
     *
     * @Then I should see a request with the parameter :param of type :type
     */
    public function iShouldSeeARequestWithTheParameterOfType($param, $type)
    {
        if ('base64' === $type) {
            $param .= "\n";
        }

        $this->iShouldSeeARequestWithTheParameterOfTypeOrig($param, $type);
    }
}
