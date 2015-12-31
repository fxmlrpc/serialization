<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;

/**
 * Defines parser features from the specific context.
 */
class ParserFeatureContext implements Context, SnippetAcceptingContext
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
