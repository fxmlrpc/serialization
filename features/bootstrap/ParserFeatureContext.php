<?php

use Behat\Behat\Context\Context;

/**
 * Defines parser features from the specific context.
 */
class ParserFeatureContext implements Context
{
    use ParserContext;

    /**
     * @param string $parserClass
     */
    public function __construct($parserClass)
    {
        $this->parser = new $parserClass();
    }
}
