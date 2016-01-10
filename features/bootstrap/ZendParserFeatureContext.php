<?php

use Behat\Behat\Context\Context;
use Fxmlrpc\Serialization\Value\Base64Value;
use Webmozart\Assert\Assert;

/**
 * Defines parser features from the specific context.
 */
class ZendParserFeatureContext implements Context
{
    use ParserContext;

    /**
     * @param string $parserClass
     */
    public function __construct($parserClass)
    {
        $this->parser = new $parserClass();
    }

    /**
     * Zend automatically decodes datetime.
     *
     * @Then I should see a datetime value :value
     */
    public function iShouldSeeADatetimeValue($value)
    {
        $value = \DateTime::createFromFormat('Y-m-d H:i:s', $value, new \DateTimeZone('UTC'));

        Assert::eq($value->format('Ymd\TH:i:s'), $this->value);
    }

    /**
     * Zend automatically decodes base64.
     *
     * @Then I should see a base64 value :value
     */
    public function iShouldSeeABase64Value($value)
    {
        $value = Base64Value::serialize($value);

        Assert::eq($value->getEncoded(), base64_encode($this->value));
        Assert::eq($value->getDecoded(), $this->value);
    }
}
